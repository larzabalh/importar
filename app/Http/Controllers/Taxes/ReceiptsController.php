<?php

namespace App\Http\Controllers\Taxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Receipt;
use App\Models\Type;
use App\Models\Person;
use App\Models\ReceiptTax;
use App\Models\PeriodLiquidation;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use \App\Http\Requests\ReceiptCreateRequest;

class ReceiptsController extends Controller
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
      $param = isset($request['param']) ? $request['param'] : null ;
      if($param){
        $receipt = Receipt::where('type_id', '=', '%'.$param.'%')
        ->where('', '=', \Auth::User()->idField())
        ->get();
        //$request->flash();
      }else{
        $receipt = Receipt::where('person_id_owner', '=', \Auth::User()->idField())
        ->get();
      }

      $types = Type::all();
      return view('receipt.index', compact('receipt', 'types') );
    }

    /**
     *  get Lis of receipts
     * @param  array  $request to future filtered
     * @return array of receipts
     */
    public function getListReceipts($person_id, Request $request){
      // $param = ($id!='') ? $id : null ;
      // if($param){
      //   $receipt = Receipt::where('type_id', '=', '%'.$param.'%')
      //   ->get();
      //   //$request->flash();
      // }else{
      //return response()->json(["data"=> $request->all()]);
        $receipt = Receipt::where('person_id_owner', '=', $person_id)
        ->where('receipts.type_id', '=', $request->input('type_id'))
        ->leftJoin('periods', function($join)
        { $join->on('receipts.period_id', '=', 'periods.id')
          ->on('receipts.person_id_owner', '=', 'periods.person_id'); })
        ->leftJoin('persons', 'receipts.person_id_relationed', '=', 'persons.id')
        ->leftJoin('receipt_types', 'receipts.type_receipt_id', '='
          , 'receipt_types.id')
        ->leftJoin('types', 'receipts.type_id', '=', 'types.id')
        ->leftJoin('zones', 'receipts.zone_id', '=', 'zones.id')
        ->leftJoin('retention_types', 'receipts.retention_type_id', '='
         , 'retention_types.id')
        ->select('receipts.id', 'receipt_date', 'number', 'code_ticket'
          , 'amount', 'receipts.code_ticket', 'status_id'
          , \DB::raw('periods.code as period_code')
          , \DB::raw('persons.field_name1 as person_field_name1')
          , \DB::raw('receipt_types.name as receipt_type_name')
          , \DB::raw('receipts.type_id as type_id')
          , \DB::raw('types.name as type_name')
          , \DB::raw('retention_types.name as retention_type_name')
          , \DB::raw('receipts.reference as reference')
          , \DB::raw('zones.name as zone_name')
          , \DB::raw('
          (select max(pl.id) from period_liquidations as pl
            where receipts.period_id=pl.period_id and pl.status<>1)
             as period_liquidation_close')
           )
           ->orderBy('periods.code', 'desc')
           ->orderBy('persons.field_name1', 'asc')
           ->orderBy('receipts.number', 'asc')->orderBy('receipts.code_ticket', 'asc')
           ->get()
        ;
        //dd($receipt);
      //
      return response()->json(["data"=> $receipt->toArray()]);

    }

    /**
     * Show form create new receipt
     * @return view
     */
    public function create($type_id, Request $request)
    {
      $periods = \App\Models\Period::where('person_id',  '=',
          session('current_person_id'))
        ->orderBy('year', 'asc')->orderBy('period_number', 'asc')->get();
      $receiptTypes = \App\Models\ReceiptType::orderBy('name', 'asc')->get();
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

      return view('receipt.form'.$type_id, compact([ 'periods', 'receiptTypes',
        'activities', 'zones', 'type_id', 'person', 'systemTaxes', 'otherTaxes',
        'tabsOtherTaxes', 'retentionTypes'
      ]));
    }

    /**
     * Show form create edit receipt
     * @return view
     */
    public function edit($id, Request $request)
    {
      $receipt = Receipt::findOrFail($id);
      $receiptTaxes = ReceiptTax::where('receipt_id', '=', $id)->get();

      $periods = \App\Models\Period::where('person_id',  '=',
          session('current_person_id'))
        ->orderBy('year', 'asc')->orderBy('period_number', 'asc')->get();
      $receiptTypes = \App\Models\ReceiptType::orderBy('name', 'asc')->get();
      $activities = \App\Models\Activity::orderBy('name', 'asc')->get();
      $zones = \App\Models\Zone::orderBy('name', 'asc')->get();
      $person = \App\Models\Person::find(session('current_person_id'));
      $systemTaxes = \App\Models\SystemTax::orderBy('taxable_iva', 'desc')
        ->orderBy('percent_iva', 'desc')
        ->select('*'
        , \DB::raw("case when apply_to='iva' then 1 else 2 end as iva"))->get();
      $otherTaxes = \App\Models\OtherTax::orderBy('section', 'asc')
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
      $type_id = $receipt->type_id;
      $receiptTaxes = $receiptTaxes->keyBy('tax_id');
      //dd($receiptTaxes);
      //dd($receiptTaxes[3]);
      return view('receipt.form'.$type_id, compact([ 'periods', 'receiptTypes',
        'activities', 'zones', 'type_id', 'person', 'systemTaxes', 'otherTaxes',
        'receipt', 'receiptTaxes', 'tabsOtherTaxes', 'retentionTypes'
      ]));

    }

    /**
     * Save a receipt
     * @param  ReceiptCreateRequest $request
     * @return Array of errors or redirect to view personalfile.edit
     */
    public function save( ReceiptCreateRequest $request )
    {

      $person = Person::find(session('current_person_id'));

      $periodLiquidation = PeriodLiquidation::where('period_id', '=', $request->only('period_id'))
        ->where('status', '<>', 1)
        ->first();
      if( $periodLiquidation ){
        $errors = ['errors' => [ 'receipt' =>
         'No se puede guardar ya que el Periodo Liquidado ya está Cerrado']];
        return  response()->json( $errors, 412 );
      }

      $type_id = $request->only(['type_id']);
      //return(\Response::json(['respuesta' =>$request->all() ] ));
        $systemTaxes = $request->requestInputsSystemTaxes($type_id);
        $otherTaxes = $request->requestInputsOtherTaxes($type_id);

      //return(\Response::json(['respuesta' => $systemTaxes ] ));
      $data =$request->requestInputs($type_id, $person, $systemTaxes, $otherTaxes);
      $data['person_id_owner'] = session('current_person_id');
      //return(\Response::json(['respuesta' => $data ] ));
      if(($request->only('receipt_id'))!=null){
        $receiptS = Receipt::findOrFail($request->only('receipt_id'))->first();
        $receiptS->fill( collect($data)->forget('receipt_id')->toArray() );
        $status =$request->only('status_id');
        if($status){
          $receiptS->status_id = $status['status_id'];
        }

      }else{
        $receiptS = new Receipt;
        $receiptS->fill( $data );
      }

      //return(\Response::json(['respuesta' => $data ] ));

      $receipt = \DB::transaction(function () use($data, $systemTaxes, $otherTaxes, $receiptS) {
        //return(\Response::json(['respuesta' => $data ] ));
        $receiptS->save( );
        //$receipt = Receipt::create($data);

        $deletes = ReceiptTax::where('receipt_id', '=',$receiptS->id )->delete();

        if($data['type_id']=="1" || $data['type_id']=="2"){
          foreach($systemTaxes['amount'] as $key => $list){
            if($list>0){
              $dataSystemTax = null;
              $dataSystemTax['receipt_id'] = $receiptS->id;
              $dataSystemTax['amount'] = str_replace(',', '.', $list);
              $dataSystemTax['tax_id'] = $key;
              $dataSystemTax['tax_amount'] = isset($systemTaxes['iva_amount'][$key]) ?
              $systemTaxes['iva_amount'][$key] : 0;
              $dataSystemTax['taxable_iibb'] = $systemTaxes['taxable_iibb'][$key];
              $dataSystemTax['iva_iibb'] = $systemTaxes['iva'][$key];
              $systemTax[] = ReceiptTax::create($dataSystemTax);
            }
          }

          foreach($otherTaxes['amount_other'] as $key => $list){
            if($list>0){
              $dataOtherTax = null;
              $dataOtherTax['receipt_id'] = $receiptS->id;
              $dataOtherTax['amount'] = str_replace(',', '.', $list);
              $dataOtherTax['tax_id'] = $key;
              $dataOtherTax['tax_amount'] = isset($otherTaxes['iva_amount'][$key]) ?
              $otherTaxes['iva_amount'][$key] : 0;
              $dataOtherTax['taxable_iibb'] = 2;
              $dataOtherTax['iva_iibb'] = $otherTaxes['apply_to'][$key];
              $otherTax[] = ReceiptTax::create($dataOtherTax);
            }
          }
          return(\Response::json(['respuesta' => $systemTax ] ));

        }

        return $receiptS;
      });

      return( \Response::json( compact('receipt') ) );
    }

    /**
     * delete a receipt by id
     * @param  integer   $id      receipt_id
     * @param  Request $request
     * @return arrayJson msj
     */
    public function delete($id, Request $request){

      $receipt = Receipt::find($id);

      if( !isset($receipt) ){
        $errors = ['errors' => [ 'receipt' => 'No existe el Comprobante']];
        return  response()->json( $errors, 412 );
      }
      if( $receipt->periodLiquidationClose() ){
        $errors = ['errors' => [ 'receipt' =>
         'No se puede eliminar ya que el Periodo Liquidado ya está Cerrado']];
        return  response()->json( $errors, 412 );
      }

      \DB::transaction(function () use($id, $receipt) {

        $deleteReceiptTaxes = ReceiptTax::where('receipt_id', '=',$receipt->id )->delete();

        $deleteReceipt = $receipt->delete();

      });

      $data = [
        'msj' => 'Eliminado Exitosamente',
        'receipt_id' => $id,
      ];
      return(\Response::json(['respuesta' => $data ] ));

    }

}
