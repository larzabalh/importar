<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Period;
use App\Models\Type;
use App\Models\Person;
use App\Models\PersonConfiguration;
use App\Models\PersonActivity;
use App\Models\PersonLiquidator;
use App\Models\PersonPayMethod;
use App\Models\PersonZone;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\BusinessCreateRequest as BCR;

class BusinessController extends Controller
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
    return view('business.index' );
  }



  /**
   *  get List of business
   * @param  array  $request to future filtered
   * @return array of business
   */
  public function getList( Request $request){
     $status =  $request->input('status_show');

      $person = Person::getListBusiness($status);

    return response()->json(["data"=> $person->toArray()]);

  }

  /**
   * Show form create new business
   * @return view
   */
  public function create( Request $request)
  {
    $documentTypes = \App\Models\Person::getDocumentTypes();
    $ivaConditions = \App\Models\IvaCondition::all();
    $personTypes = \App\Models\PersonType::all();

    $iibbObligations = [1=>'NO', 'SICOL', 'ARBA', 'CONVENIO MULTILATERAL'];
    $priorityOrder = [1=>'Alta', 'Media', 'Baja'];
    $otherTaxes = [ 1=>'SICORE', 'SEGURIDAD E HIGIENE', 'SECRETARIA DE ENERGIA'];

    $months = [
      1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril', 5=>'Mayo', 6=>'Junio',
      7=>'Julio', 8=>'Agosto', 9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre',
      12=>'Diciembre',
    ];

    //para definirlo bien en la vista, ya que tengo 1 en el que suma todo
    $iibbCalculates = [ 2=>'ASIGNACION DIRECTA', 1=>'CONVENIO MULTILATERAL'];

    $business = $businessConfiguration = $businessActivities = [];
    $businessLiquidators = $businessZones = $businessPayMethods = [];
    $inA = $inZ = $inL = $inPM = [];
    if($request->route('id')){
      $business = Person::find($request->route('id'));
      //dd($business);
      $businessConfiguration = $business->configuration[0];

      $businessActivities = $business->activities();
      $businessLiquidators = $business->liquidators();
      $businessZones = $business->zones2();
      $businessPayMethods = $business->payMethods();
      $inA = $businessActivities->pluck('activity_id');
      $inZ = $businessZones->pluck('zone_id');
      $inL = $businessLiquidators->pluck('liquidator_id');
      $inPM = $businessPayMethods->pluck('pay_method_id');
    }

    $activities = \App\Models\Activity::whereNotIn('id', $inA)
      ->orderBy('name', 'asc')->get();
    $zones = \App\Models\Zone::whereNotIn('id', $inZ)
      ->orderBy('name', 'asc')->get();
    $payMethods = \App\Models\PayMethod::whereNotIn('id', $inPM)
      ->orderBy('description', 'asc')->get();
    $liquidators = \App\Models\Liquidator::whereNotIn('id', $inL)
      ->orderBy('name', 'asc')->get();


    return view('business.form', compact(['documentTypes', 'ivaConditions',
      'iibbObligations', 'otherTaxes', 'activities', 'businessActivities',
      'personTypes', 'zones', 'businessZones', 'months', 'iibbCalculates',
      'businessLiquidators', 'payMethods', 'businessPayMethods',
      'liquidators', 'business', 'businessConfiguration', 'priorityOrder']));
  }

  /**
   * find a periodLiquidation basic data
   * @return json data and http code
   */
  public function find($id, Request $request)
  {

    $person = PeriodLiquidation::find($id);

    if( !isset($person) ){
      $errors = ['errors' => [ 'period' => 'No existe el periodo']];
      return  response()->json( $errors, 412 );
    }

    return  response()->json( [ $person ], 200 );

  }



  /**
   * Show form create show business
   * @return view
   */
  public function show($id, Request $request)
  {
    $person = Person::find($id);
    $personConf = $person->configuration[0];
    //dd($person->period_liquidation('iibb'));
    return view ('business.iva', compact([ 'business' , 'details' ,
      'previousPeriod', 'prevPeriodLiquidationIVA', 'liquidationIVARetPerComp'
      , 'periodLiquidationIVA', 'perLiqIVADet']) );
  }



  /**
   * Save a business
   * @param  Request $request
   * @return Array of errors or redirect to view save
   */
  public function save( BCR $request )
  {

    //return (\Response::json(['respuesta' => $request->all() ] , 400));

    $data = $request->all();
    //0.1 valido los datos (Crear request para el save)
      //Falta la validacion busque solo las empresas con configuraciones

    //1 Creo o Busco el objeto persona y Empresa
      //tabla persons
      if(isset($data['person_id'])){
        $person = Person::find($data['person_id']);
        //return (\Response::json(['respuesta' => 'aqui quede' ] , 400));
        //return (\Response::json(['respuesta' => $personConf ] , 400));
      }else{
        //deberia de buscar a la persona por si es cliente o proveedor, y asi actualizarla
        //sino creo la persona desde cero.
        $person = (Person::where('document', '=', $data['document'])
          ->where('document_type', '=', $data['document_type'])->first()) ?? (new Person);
      }

      //primer elemento del array de Actividades
      $temp1 = $data['activity_id'];
      $temp1 = isset($temp1)?array_shift($temp1):null;

      //primer elemento del array de Zonas
      $temp2 = $data['zone_id'];
      $temp2 = isset($temp2)?array_shift($temp2):null;

      //guardo los datos los cambios en arrays por separado.
      $dataPerson['activity_id'] = $temp1;
      $dataPerson['address'] = $data['address'];
      $dataPerson['document'] = $data['document'];
      $dataPerson['document_type'] = strtolower($data['document_type']);
      $dataPerson['field_name1'] = $data['field_name1'];
      $dataPerson['zone_id'] = $temp2;
      $dataPerson['person_type_id'] = $data['person_type_id'];

      $dataPersonConf['active'] = $data['active'];
      $dataPersonConf['month_close'] = $data['month_close'];
      $dataPersonConf['iva_condition_id'] = $data['iva_condition_id'];
      $dataPersonConf['obligation_sell'] = isset($data['obligation_sell'])?'1':'0';
      $dataPersonConf['obligation_buy'] = isset($data['obligation_buy'])?'1':'0';
      $dataPersonConf['obligation_iva'] = isset($data['obligation_iva'])?'1':'0';
      $dataPersonConf['obligation_electronic_receipt'] = isset($data['obligation_electronic_receipt'])?'1':'0';
      $dataPersonConf['obligation_salaries'] = isset($data['obligation_salaries'])?'1':'0';
      $dataPersonConf['obligation_iibb'] = $data['obligation_iibb'];
      $dataPersonConf['obligation_other_taxes'] = $data['obligation_other_taxes']??null;
      $dataPersonConf['priority_order'] = $data['priority_order']??null;
      $dataPersonConf['liquidation_start_period'] =
        isset($data['liquidation_start_period'])?$data['liquidation_start_period']:null;
      $dataPersonConf['settle_calc_by_coef'] = $data['settle_calc_by_coef']??'0';

      //tabla person_configuration
      //si tiene configuracion cargada
      if(isset($person) && isset($person->configuration) && isset($person->configuration[0])){
        $personConf = $person->configuration[0];
      }else{
        //sino la creo
        $personConf = new PersonConfiguration;
      }

    //2 entro en la transaccion
    $retorno = \DB::transaction(function () use($data, $dataPerson, $person,
      $dataPersonConf, $personConf) {
      //2.1 guardo el objeto persons
      $person->fill($dataPerson);
      $person->save();
      //asigno periodos a empresas sin periodos asignados.
      if( $data['liquidation_start_period']){
        $period = explode('-', $data['liquidation_start_period']);
        //return $period;
        $person->assignNewPeriods($period[0], $period[1]);
      }

      //2.2 guardo el person_id en el objeto person_configuration
      $personConf->fill($dataPersonConf);
      $personConf->person_id=$person->id;
      $personConf->save();

      //previo elimino las Actividades
      $deletes = \DB::table('person_activities')
        ->where('person_id', '=', $person->id )->delete();
      //2.3 Foreach para las actividades
      if( $data['activity_id'] ){
        foreach($data['activity_id'] as $key => $list){
          $dataAct = null;
          $dataAct['person_id'] = $person->id;
          $dataAct['activity_id'] = $key;
          $created[] = PersonActivity::create($dataAct);
        }
      }

      //previo elimino las Actividades
      $deletes = \DB::table('person_zones')
        ->where('person_id', '=', $person->id )->delete();
      //2.4 Foreach para las Zonas
      if( $data['zone_id'] ){
        foreach($data['zone_id'] as $key => $list){
          $dataAct= null;
          $dataAct['person_id'] = $person->id;
          $dataAct['zone_id'] = $key;
          $dataAct['sifere_coef'] = str_replace(',', '.', $data['sifere_coef'][$key]);
          $dataAct['iibb_aliquot'] = str_replace(',', '.', $data['iibb_aliquot'][$key]);
          $created[] = PersonZone::create($dataAct);
        }
      }

      //previo elimino a los liquidadores
      $deletes = \DB::table('person_liquidators')
        ->where('person_id', '=', $person->id )->delete();
      //2.5 Foreach para Liquidadores
      if( $data['liquidator_id'] ){
        foreach($data['liquidator_id'] as $key => $list){
          $dataAct = null;
          $dataAct['person_id'] = $person->id;
          $dataAct['liquidator_id'] = $key;
          //return $dataAct;
          $created[] = PersonLiquidator::create($dataAct);
        }
      }

      //previo elimino a los metodos de pago
      $deletes = \DB::table('person_pay_methods')
        ->where('person_id', '=', $person->id )->delete();
      //2.6 Si hay Foreach para Metodos de Pago
      if( $data['pay_method_id'] ){
        foreach($data['pay_method_id'] as $key => $list){
          $dataAct = null;
          $dataAct['person_id'] = $person->id;
          $dataAct['pay_method_id'] = $key;
          $created[] = PersonPayMethod::create($dataAct);
        }
      }
      return( ['msj' => 'Guardados Exitosamente' ] );
    });

    $person->assignBusinessToUsers();

    return(\Response::json(['respuesta' => $retorno ], 201 ));
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
    return view('business.iibb_delete', compact([ 'periodLiquidation', 'period']));

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


}
