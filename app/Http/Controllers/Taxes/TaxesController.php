<?php

namespace App\Http\Controllers\Taxes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaxesController extends Controller
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
   * dashboard for Taxes
   * @return view
   */
    public function dashboard(){
      //dd(\Auth::user()->userModule);
      return view('taxes.dashboard');
    }

    

}
