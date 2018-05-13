<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Period;

class PeriodsController extends Controller
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
    public function search(Request $request)
    {
      $param = isset($request['param']) ? $request['param'] : null ;
      if($param){
        $receipt = Period::where('code', 'like', '%'.$param.'%')
        ->where('person_id', '=', session('current_person_id'))
        ->get();
        //$request->flash();
      }else{
        $receipt = Period::where('person_id', '=', session('current_person_id'))
        ->get();
      }

      return response()->json(["data"=> $receipt->toArray()]);
    }

    /**
     *  get Lis of periods
     * @param  array  $request to future filtered
     * @return array of receipts
     */
    public function getListPeriods($person_id){

      $list = Period::where('person_id', '=', $person_id)
      /*->select('receipts.id', 'receipt_date', 'office', 'code_ticket'
        , 'amount', 'receipts.code_ticket' )*/
         ->get()
      ;

      return response()->json(["data"=> $list->toArray()]);

    }

    /**
     * Show form create period
     * @return view
     */
    public function create($id, Request $request)
    {
    /*  $periods = \App\Models\Period::where('person_id',  '=',
          session('current_person_id'))
        ->orderBy('year', 'asc')->orderBy('period_number', 'asc')->get();
      $receiptTypes = \App\Models\PeriodType::all();
      $activities = \App\Models\Activity::all();
      $zones = \App\Models\Zone::orderBy('name', 'asc')->get();

      return view('receipt.new'.$id, compact([ 'periods', 'receiptTypes',
        'activities', 'zones'
      ]));
      */
    }

}
