<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \App\Models\Country;

class CountrysController extends Controller
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
   * find a state by login or email
   * @param gy bet loginUser or emailUser
   * @return json object or false
   */
  public function allCountrys(Request $request)
  {
    $countrys = Country::orderBy('countryName', 'asc')->get();

    return \Response::json(compact('countrys'));
  }






}
