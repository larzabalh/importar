<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;

class CompanyController extends Controller
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
   * [getCompanySons description]
   * @return [type] [description]
   */
  public function getCompanySons($id){

    $companies =  \Auth::User()->userSonsPersons()->get();
    //dd($companies);

    return(\Response::json(compact('companies')));

  }


  public function setCurrent(Request $request, $id){
    $request->session()->put('current_person_id', $id);
    $request->session()->put('current_person',
      Person::find($id)->field_name1
    );
    return (\Response::json(
      [ 'status' => 200,
        'current_person_id'=>session('current_person_id')]));
  }



}
