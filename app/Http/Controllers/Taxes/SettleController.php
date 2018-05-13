<?php

namespace App\Http\Controllers\Taxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Period;
use App\Models\Type;
use App\Models\Person;
use App\Models\PersonZone;
use App\Models\PeriodLiquidation;
use App\Models\PeriodLiquidationDetail;
use App\Models\PeriodLiquidationIVA;
use App\Models\PeriodLiquidationIVADetail;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use \App\Http\Requests\SettleCreateRequest;
use \App\Http\Requests\SettleGenerateRequest;

class SettleController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    /*$param = isset($request['param']) ? $request['param'] : null ;
    if($param){
      $settle = Period::where('type_id', '=', '%'.$param.'%')
      ->where('person_id', '=', \Auth::User()->idField())
      ->get();
      //$request->flash();
    }else{
      $settle = Period::where('person_id', '=', \Auth::User()->idField())
      ->orderBy('year', 'desc')->orderBy('period_number', 'desc')->get();
    }*/

    $types = PeriodLiquidation::getApplys();
    return view('settle.index', compact('types') );
  }

  /**
   *  get Lis of periods and period_liquidations
   * @param  array  $request to future filtered
   * @return array of periods
   */
  public function getListSettle($person_id, Request $request){
     $status =  $request->input('status_show');
    // if($param){
    //   $settle = Period::where('type_id', '=', '%'.$param.'%')
    //   ->get();
    //   //$request->flash();
    // }else{
    //return response()->json(["data"=> $request->all()]);

      $settle = Period::where('periods.person_id', '=', $person_id)
    ->join('period_liquidations',  function($join) use ($status){
      $join->on('periods.id', '=', 'period_liquidations.period_id')
      ->where('period_liquidations.status', '=', $status);
    })
    ->select('periods.id', 'periods.code', 'periods.year', 'periods.period_number'
      , 'period_liquidations.apply_to', 'period_liquidations.status'
      , \DB::raw("upper(period_liquidations.apply_to) as type")
      , \DB::raw("upper(period_liquidations.id) as period_liquidation_id")
      ,'period_liquidations.updated_at'  )
    ->orderBy('periods.year', 'desc')->orderBy('periods.period_number', 'desc')
    ->orderBy('period_liquidations.apply_to', 'desc')
    ->get()
      ;
      //dd($settle);
    //
    return response()->json(["data"=> $settle->toArray()]);

  }

  /**
   * Show form create new settle
   * @return view
   */
  public function create($type_id, Request $request)
  {
    $periods = \App\Models\Period::where('person_id',  '=',
        session('current_person_id'))
      ->orderBy('year', 'asc')->orderBy('period_number', 'asc')->get();
    $settleTypes = \App\Models\SettleType::orderBy('name', 'asc')->get();
    $activities = \App\Models\Activity::orderBy('name', 'asc')->get();
    $zones = \App\Models\Zone::orderBy('name', 'asc')->get();
    $person = \App\Models\Person::find(session('current_person_id'));
    $systemTaxes = \App\Models\SystemTax::orderBy('taxable_iva', 'desc')
      ->orderBy('percent_iva', 'desc')
      ->select('*'
      , \DB::raw("case when apply_to='iva' then 1 else 2 end as iva"))->get();
    $otherTaxes = \App\Models\OtherTax::orderBy('section', 'desc')
      ->orderBy('name', 'asc')
      ->select('*'
      , \DB::raw("case when section='iva' then 1
      when section='iibb' then 2
      when section='gas' then 3  end as iva"))->get();
    $tabsOtherTaxes = $otherTaxes;

    $retentionTypes = \App\Models\RetentionType::orderBy('apply_to', 'asc')
      ->orderBy('name', 'asc')->get();
    /*$statesForeigns = \App\Models\State::where('idCountry', 5)->get();
    $immigrationSituations = ImmigrationSituation::all();
    $bloodTypes = \App\Traits\ConstantPeople::getBloodTypes();*/

    return view('settle.form'.$type_id, compact([ 'periods', 'settleTypes',
      'activities', 'zones', 'type_id', 'person', 'systemTaxes', 'otherTaxes',
      'tabsOtherTaxes', 'retentionTypes'
    ]));
  }

  /**
   * find a periodLiquidation basic data
   * @return json data and http code
   */
  public function find($id, Request $request)
  {

    $settle = PeriodLiquidation::find($id);

    if( !isset($settle) ){
      $errors = ['errors' => [ 'period' => 'No existe el periodo']];
      return  response()->json( $errors, 412 );
    }

    return  response()->json( [ $settle ], 200 );

  }


  public function recalculate($type, $period_liquidation_id, $person_id, Request $request)
  {

    $settle = PeriodLiquidation::find($period_liquidation_id);

    $person = Person::find($person_id);

    $previousPeriod = $settle->previousPeriodLiquidation();
    //var_dump($previousPeriod); die;
    //dd($settle->period_liquidation('iibb'));
    if($type=='iibb'){
      //obtengo las zonas y si tienen liquidaciones para un periodo; las traigo
      $personZones = $person->periodLiquidation($period_liquidation_id);

      $ins = $personZones->pluck('zone_id');

      $prev_period_id = $previousPeriod ? $previousPeriod->period_id : "''";
      $base = PeriodLiquidationDetail::zonesAmountsReceipts($settle->period_id, $prev_period_id);
      $baseEquals=null;

      //dd($person->configuration[0]->settle_calc_by_coef);
      //cuando es calculo por CONVENIO MULTILATERAL
      if($person->configuration[0]->settle_calc_by_coef===1){
        $baseEquals = PeriodLiquidationDetail::generalBaseAmount($settle->period_id, $ins);
        //dd(x  );
      }

      //dd($base);
      //return (\Response::json(['respuesta' => $settle ], 200 ));
      return view('settle.iibb', compact([ 'settle', 'personZones', 'base',
      'baseEquals', 'previousPeriod' ]));

    }else if($type=='iva'){

      $details = PeriodLiquidationIVA::toGenerate($settle->period_id, $person_id);
       //dd($details);
      $prevPeriodLiquidationIVA = $previousPeriod ?
        $previousPeriod->periodLiquidationIVA()->first() : null;

      $liquidationIVARetPerComp = $settle->liquidationIVARetPerComp();


      //traigo el detalle y lo mando
      //dd( $liquidationIVARetPerComp ) ;

      return (\Response::json([ $details, $liquidationIVARetPerComp,
        $prevPeriodLiquidationIVA  ], 200 ));
    }
  }

  /**
   * Show form create edit settle
   * @return view
   */
  public function show($id, Request $request)
  {

    $settle = PeriodLiquidation::findOrFail($id);
    $person = Person::find($settle->person_id);
    $previousPeriod = $settle->previousPeriodLiquidation();
    //dd($settle->period_liquidation('iibb'));
    if($settle->apply_to=='iibb'){
      //obtengo las zonas y si tienen liquidaciones para un periodo; las traigo
      $personZones = $person->periodLiquidation($id);

      $ins = $personZones->pluck('zone_id');

      $prev_period_id = $previousPeriod ? $previousPeriod->period_id : "''";
      $base = PeriodLiquidationDetail::zonesAmountsReceipts($settle->period_id, $prev_period_id);
      $baseEquals=null;

      //dd($person->configuration[0]->settle_calc_by_coef);
      if($person->configuration[0]->settle_calc_by_coef===1){
        $baseEquals = PeriodLiquidationDetail::generalBaseAmount($settle->period_id, $ins);
        //dd(x  );
      }

      //dd($base);
      return view('settle.iibb', compact([ 'settle', 'personZones', 'base',
      'baseEquals', 'previousPeriod' ]));

    }else if($settle->apply_to=='iva'){
      // dd($settle);
      $details = PeriodLiquidationIVA::toGenerate($settle->period_id
        , session('current_person_id'));
      //dd($details);
      $prevPeriodLiquidationIVA = $previousPeriod ?
        $previousPeriod->periodLiquidationIVA()->first() : null;
        //dd($prevPeriodLiquidationIVA);
      $periodLiquidationIVA = $settle->periodLiquidationIVA;
      $liquidationIVARetPerComp = $settle->liquidationIVARetPerComp();
      $perLiqIVADet = $periodLiquidationIVA ?
        ($periodLiquidationIVA->details->keyBy(function ($item) {
          return $item['ordr'].'-'.$item['activity_id'].'-'.$item['type']
          .'-'.$item['tax_id'];
        })->toArray()) : null;

      //traigo el detalle y lo mando
      //dd( $liquidationIVARetPerComp ) ;

      return view ('settle.iva', compact([ 'settle' , 'details' ,
      'previousPeriod', 'prevPeriodLiquidationIVA', 'liquidationIVARetPerComp'
      , 'periodLiquidationIVA', 'perLiqIVADet']) );
    }
  }

  /**
   * generate a new period liquidation and this details
   * @return view
   */
  public function generate( SettleGenerateRequest $request)
  {
    //return (\Response::json(['respuesta' => $request->all() ] , 210));
    // return (\Response::json(['respuesta' => $request->all() ] ));
    //busco el periodo actual y el periodo anterior
    $period = Period::findOrFail($request->only('period_id'))->first();
    $prev = $period->previousPeriod();
    $apply_to = $request->only('apply_to');
    $apply_to = $apply_to['apply_to'];
    //si el periodo anterior existe y la liquidacion no está cerrada, no puedo
    //  generar la actual
    if($prev){
      $prevPeriodLiquidation = PeriodLiquidation::where('period_id', '=',
        $prev->id)->where('apply_to', '=', $request->only('apply_to'))
        ->first();
      /*if( !isset($prevPeriodLiquidation) ){
        $errors = ['errors' => [ 'prevPeriod' => 'No ha sido cargada la'.
          ' liquidacion anterior' ]];
        return  response()->json( $errors, 412 );
      }*/
      /*elseif( $prevPeriodLiquidation->status!=2 ){
        $errors = ['errors' => [ 'prevPeriod' => 'No ha sido cerrada la'.
          ' liquidacion anterior' ]];
        return  response()->json($errors, 412 );
      }*/
    }

    $periodLiquidation = PeriodLiquidation::where('period_id', '=',
      $period->id)->where('apply_to', '=', $request->only('apply_to'))
      ->first();
    //return (\Response::json(['respuesta' => $prevPeriodLiquidation ] ));
    if($periodLiquidation){
      return (\Response::json([ $periodLiquidation ], 200));
    }


    //$periods = Period::where( 'person_id', '=', session('current_person_id') ) ->get();
    $person = Person::find(session('current_person_id'));
    if(count($person->configuration)===0){
      $errors = ['errors' => [ 'conf' => 'No ha sido cargada la '.
        ' configuración de la Empresa' ]];
      return  response()->json($errors, 412 );
    }

    if($apply_to=='iibb'){
      $personZones = $person->zones;
      $ins = $personZones->pluck('zone_id');
      $prev_period_id = $prev ? $prev->id : "''";
      $base = PeriodLiquidationDetail::zonesAmountsReceipts($period->id, $prev_period_id);
      $baseEquals=null;

      if($person->configuration[0]->settle_calc_by_coef===1){
        $baseEquals = PeriodLiquidationDetail::generalBaseAmount($period->id, $ins);
        //dd(x  );
      }

      //return (\Response::json(['respuesta' => $base ], 202 ));

      $settle = \DB::transaction(function () use($personZones, $period, $base
      , $baseEquals, $request, $apply_to) {
        $dataPeriodLiq=null;
        $dataPeriodLiq = ['period_id' => $period->id,
         'person_id' => session('current_person_id'),
         'apply_to' => $apply_to,
        ];
        //return (\Response::json(['respuesta' => $base ], 202 ));

        $periodLiquidation = PeriodLiquidation::create($dataPeriodLiq);

        foreach ($personZones as $value) {
          $key=$value->zone_id;
          $amount = isset($baseEquals) ? $baseEquals->amount :
          (isset($base[$key]) ? $base[$key]->base_amount : '0.00');
          $sircreb = isset($base[$key]) ? $base[$key]->sircreb_amount : '0.00';
          $retention = isset($base[$key]) ? $base[$key]->retention_amount :'0.00';
          $perception = isset($base[$key]) ? $base[$key]->perception_amount :'0.00';
          $previous = isset($base[$key]) ? ($base[$key]->previous_period_balance??'0.00') :'0.00';
          $tax = ($amount*$value['sifere_coef']*($value['iibb_aliquot']/100));
          $result = $tax - $previous - $sircreb - $retention - $perception;
           $negative = $result>0 ? $result :'0.00';
           $positive = $result<0 ? $result*(-1) :'0.00';

          $dataPeriodLiqDet['previous_period_balance'] = $previous;
          $dataPeriodLiqDet['period_liquidation_id'] = $periodLiquidation->id;
          $dataPeriodLiqDet['period_id'] = $period->id;
          $dataPeriodLiqDet['person_id'] = session('current_person_id');
          $dataPeriodLiqDet['zone_id'] = $key;
          $dataPeriodLiqDet['coef'] = $value['sifere_coef'];
          $dataPeriodLiqDet['aliquot'] = $value['iibb_aliquot'];
          $dataPeriodLiqDet['base_amount'] = $amount ? $amount : 0;
          $dataPeriodLiqDet['tax_amount'] = $tax;
          $dataPeriodLiqDet['previous_period_balance'] = $previous;
          $dataPeriodLiqDet['sircreb_amount'] = $sircreb;
          $dataPeriodLiqDet['perception_amount'] = $perception;
          $dataPeriodLiqDet['retention_amount'] = $retention;
          $dataPeriodLiqDet['positive_amount'] = $positive;
          $dataPeriodLiqDet['negative_amount'] = $negative;
          $dataPeriodLiqDet['balance'] =  $positive>0 ? 1 : 2;
          //return (\Response::json(['respuesta' => $dataPeriodLiqDet ], 201 ));
          // guardo el detail
          $created = PeriodLiquidationDetail::create($dataPeriodLiqDet);
        }
        return $periodLiquidation;

      });

      $settle['period_code'] = $request->only('period_code');
      $settle['period_code'] = $settle['period_code']['period_code'];

    }elseif($apply_to=='iva'){

      $settle = \DB::transaction(function () use($period, $request, $apply_to) {
        $dataPeriodLiq = [];
        $dataPeriodLiq = ['period_id' => $period->id,
         'person_id' => session('current_person_id'),
         'apply_to' => $apply_to,
        ];
        //return (\Response::json(['respuesta' => $base ], 202 ));

        $periodLiquidation = PeriodLiquidation::create($dataPeriodLiq);

        return $periodLiquidation;
      });

    }

    return (\Response::json(['respuesta' => $settle ], 201 ));
  }

  /**
   * Save a settle
   * @param  Request $request
   * @return Array of errors or redirect to view save
   */
  public function save( Request $request )
  {
    //return (\Response::json(['respuesta' => $request->all() ] , 400));

    $data = $request->all();
    //0.1 valido los datos y busco el period y period_liquidation
    $period = Period::findOrFail($request->only('period_id'))->first();
    //return (\Response::json(['respuesta' => $period ] ));

    //0.2 busco el period_liquidation_id
    $periodLiquidation = PeriodLiquidation::where('period_id', '='
      , $request->only('period_id'))->where('apply_to', '='
        , $request->only('apply_to'))->first();
    //return (\Response::json(['respuesta' => $periodLiquidation ] ));
    //return (\Response::json(['respuesta' => $data ] ));
    $settle = \DB::transaction(function () use($data, $period, $periodLiquidation) {

      //0 actualizo el status y Guardado
      $periodLiquidation->status=$data['status'];
      $periodLiquidation->save();

      if($data['apply_to']=='iibb'){
        //1 Elimino los details anteriores
        $deletes = \DB::table('period_liquidation_details')
          ->where('period_liquidation_id', '=', $periodLiquidation->id )->delete();

        foreach($data['aliquot'] as $key => $list){
            $dataPeriodLiqDet = null;
            $dataPeriodLiqDet['period_liquidation_id'] = $periodLiquidation->id;
            $dataPeriodLiqDet['period_id'] = $period->id;
            $dataPeriodLiqDet['person_id'] = session('current_person_id');
            $dataPeriodLiqDet['zone_id'] = $key;
            $dataPeriodLiqDet['coef'] = str_replace(',', '.', $data['coef'][$key]);
            $dataPeriodLiqDet['aliquot'] = str_replace(',', '.', $list);
            $dataPeriodLiqDet['base_amount'] = str_replace(',', '.'
              , $data['base_amount'][$key]);
            $dataPeriodLiqDet['tax_amount'] = str_replace(',', '.'
              , $data['tax_amount'][$key]);
            $dataPeriodLiqDet['previous_period_balance'] = str_replace(',', '.'
              , $data['previous_period_balance'][$key]);
            $dataPeriodLiqDet['sircreb_amount'] = str_replace(',', '.'
              , $data['sircreb_amount'][$key]);
            $dataPeriodLiqDet['perception_amount'] = str_replace(',', '.'
              , $data['perception_amount'][$key]);
            $dataPeriodLiqDet['retention_amount'] = str_replace(',', '.'
              , $data['retention_amount'][$key]);
            $dataPeriodLiqDet['positive_amount'] = str_replace(',', '.'
              , $data['positive_amount'][$key]);
            $dataPeriodLiqDet['negative_amount'] = str_replace(',', '.'
              , $data['negative_amount'][$key]);
            $dataPeriodLiqDet['balance'] =  str_replace(',', '.'
              , $data['positive_amount'][$key])>=0 ? 1 : 2;

            //3 guardo el detail
            $created = PeriodLiquidationDetail::create($dataPeriodLiqDet);

            //**** esto ya no se hará ***
            //3.1 guardo en el siquiente periodo el balance si es positivo *listo
            //  Si existe ese periodo debe de estar status 1 <----------------
            //   , actualizo previous_period_balance *listo
            //  Sino lo creo con los datos en cero *listo
            /*$positive_amount =str_replace(',', '.',$data['positive_amount'][$key]);
            if($positive_amount>0){
              $nextPeriod = Period::find(($period->id)+1);
              $nextPeriodLiquidation = PeriodLiquidation::where('period_id', '='
              , $period->id+1)->where('apply_to', '=', $data['apply_to'])
              ->first();
              $nextPerLiqDet=PeriodLiquidationDetail::where('period_liquidation_id'
                , '=', $nextPeriodLiquidation->id)->where('zone_id', '=',$key)
              ->first();
              if(!$nextPerLiqDet){
                $dataPLD['period_liquidation_id'] = $nextPeriodLiquidation->id;
                $dataPLD['period_id'] = $nextPeriod->id;
                $dataPLD['person_id'] = session('current_person_id');
                $dataPLD['zone_id'] = $key;
                $dataPLD['previous_period_balance'] = $postive_amount;
                $nextPerLiqDet = new PeriodLiquidationDetail;
                $nextPerLiqDet->fill( $dataPLD );
              }
              $nextPerLiqDet->previous_period_balance =$positive_amount;
              $nextPerLiqDet->save();
              /*return (\Response::json(['respuesta' =>
                [$nextPeriod, $nextPeriodLiquidation, $nextPerLiqDet] ])); */

            /* } */
          }
      }else if($data['apply_to']){
            //return(\Response::json(['datos' => $data ] ));
          $dataPeriodLiqIVA = null;
          $dataPeriodLiqIVA = [
            'total_debit' => str_replace(',', '.',$data['total_debit']),
            'total_credit' => str_replace(',', '.',$data['total_credit']),
            'previous_technical' => str_replace(',', '.',$data['previous_technical']),
            'technical_balance' => str_replace(',', '.',$data['technical_balance']),
            'previous_free_availability' => str_replace(',', '.',$data['previous_free_availability']),
            'retention_amount' => str_replace(',', '.',$data['retention_amount']),
            'perception_amount' => str_replace(',', '.',$data['perception_amount']),
            'compensation_amount' => str_replace(',', '.',$data['compensation_amount']),
            'total_perceptions_retentions' => str_replace(',', '.',$data['total_perceptions_retentions']),
            'free_availability_balance' => str_replace(',', '.',$data['free_availability_balance']),
            'negative_amount' => str_replace(',', '.',$data['negative_amount']),
            'positive_amount' => str_replace(',', '.',$data['positive_amount']),
            'total_free_availability' => str_replace(',', '.',$data['total_free_availability']),
          ];

          $periodLiquidationIVA = PeriodLiquidationIVA::
            find($data['period_liquidation_iva_id']);
        //actualizo el IVA de la tabla si esta generado
          if($periodLiquidationIVA){

          }else{
            //  o creo uno nuevo
            $periodLiquidationIVA = new PeriodLiquidationIVA;
            $dataPeriodLiqIVA['period_id'] = $period->id;
            $dataPeriodLiqIVA['period_liquidation_id'] = $periodLiquidation->id;
            $dataPeriodLiqIVA['person_id'] = session('current_person_id');
          }

          $periodLiquidationIVA->fill($dataPeriodLiqIVA);
          $periodLiquidationIVA->save();

        //borro y guardo el detalle?
        $deletes = \DB::table('period_liquidation_iva_details')
          ->where('period_liquidation_iva_id', '=', $periodLiquidation->id )->delete();

          foreach($data['tax_id'] as $key => $list){
            $dataDetailIVA=[];
            $dataDetailIVA['period_liquidation_id'] = $periodLiquidation->id;
            $dataDetailIVA['period_liquidation_iva_id'] = $periodLiquidationIVA->id ;
            $dataDetailIVA['period_id'] = $period->id;
            $dataDetailIVA['person_id'] = session('current_person_id');
            $dataDetailIVA['activity_id'] = $data['activity_id'][$key];
            $dataDetailIVA['type'] = $data['type'][$key];
            $dataDetailIVA['tax_id'] = $list;
            $dataDetailIVA['ordr'] = $data['ordr'][$key];
            $dataDetailIVA['taxabled_amount'] = str_replace(',', '.'
              ,$data['taxabled_amount'][$key]);
            $dataDetailIVA['iva_amount'] = str_replace(',', '.'
              ,$data['iva_amount'][$key]);
            $created = PeriodLiquidationIVADetail::create($dataDetailIVA);
          }


        }
      return(\Response::json(['respuesta' => ['msj' => 'Guardados Exitosamente' ]] ));

    });

    return(\Response::json(['respuesta' => $settle ] ));
  }


  /**
   * validate and show confirm delete a  period liquidation
   * @return view
   */
  public function showDelete($id, Request $request)
  {
    //return (\Response::json(['respuesta' =>$id ] , 210));
    $periodLiquidation = PeriodLiquidation::find($id);
    $period = $periodLiquidation->period;
     //return (\Response::json(['respuesta' => $periodLiquidation ] ));
    if($periodLiquidation->status!=1){
      $errors = ['errors' => [ 'errorStatus' => 'La Liquidacion '
      .strtoupper($periodLiquidation->apply_to).' '.$period->code.'
      no se encuentra abierta' ] ];
        return  response()->json( $errors, 412 );
    }
    return view('settle.iibb_delete', compact([ 'periodLiquidation', 'period']));

      /*return (\Response::json([ 'periodLiquidation'=>$periodLiquidation,
        'period'=> $periodLiquidation->period ], 200));*/
  }

  /**
   * validate and show confirm delete a  period liquidation
   * @return view
   */
  public function confirmDelete( Request $request)
  {
    //return (\Response::json(['respuesta' => $request->all() ] , 210));
    $id = $request->only('period_liquidation_id');
    $periodLiquidation = PeriodLiquidation::find($id['period_liquidation_id']);
    //return (\Response::json(['respuesta' => $periodLiquidation ] , 210));
    if($periodLiquidation->status!=1){
        $errors = ['errors' => [ 'errorStatus' => 'La Liquidacion '
        .strtoupper($periodLiquidation->apply_to).' '.$period->code.'
        no se encuentra abierto' ] ];
        return  response()->json( $errors, 412 );
    }

    //aqui si elimino y todos felices

    \DB::transaction(function () use( $periodLiquidation) {

      PeriodLiquidationDetail
      ::where('period_liquidation_id', '=',$periodLiquidation->id )->delete();
      PeriodLiquidationIVADetail
      ::where('period_liquidation_id', '=',$periodLiquidation->id )->delete();
      PeriodLiquidationIVA
      ::where('period_liquidation_id', '=',$periodLiquidation->id )->delete();

      $periodLiquidation->delete();

    });

    return (\Response::json([ 'msj'=>'deleted'], 200));
  }


  /**
   * validate open a period liquidation
   * @return view
   */
  public function open( Request $request)
  {
    //return (\Response::json(['respuesta' => $request->all() ] , 210));
    $id = $request->only('period_liquidation_id');
    $periodLiquidation = PeriodLiquidation::find($id['period_liquidation_id']);
    //return (\Response::json(['respuesta' => $periodLiquidation ] , 210));
    $period = $periodLiquidation->period;
    if($periodLiquidation->status!=2){
        $errors = ['errors' => [ 'errorStatus' => 'La Liquidacion '
        .strtoupper($periodLiquidation->apply_to).' '.$period->code.'
        no se encuentra cerrada, por favor
        <a href="'.route('settle.index').'">REFRESCA</a> la pantalla.' ] ];
        return  response()->json( $errors, 412 );
    }

    //aqui si elimino y todos felices

    $periodLiquidation->status=1;
    $periodLiquidation->save();

    return (\Response::json([ 'msj'=>'unlocked'], 200));
  }


  /** ????????? NO use
   * validate al close the period_liquidation
   * @param  integer  $id      period_liquidation_id
   * @param  Request $request
   * @return array  errors or ok msj
   */
  public function close($id, Request $request)
  {

    //Validar:
    //  1)Si hay otro periodo anterior y si esta cerrado


    return(\Response::json(['respuesta' => $request->all() ] ));
  }

  /**
   * delete a settle by id  NO USE
   * @param  integer   $id      settle_id
   * @param  Request $request
   * @return arrayJson msj
   */
  /*public function delete($id, Request $request){

    $settle = Period::find($id);

    \DB::transaction(function () use($id, $settle) {

      $deleteSettleTaxes = SettleTax::where('settle_id', '=',$settle->id )->delete();

      $deleteSettle = $settle->delete();

    });

    $data = [
      'msj' => 'Eliminado Exitosamente',
      'settle_id' => $id,
    ];
    return(\Response::json(['respuesta' => $data ] ));

  }*/

}
