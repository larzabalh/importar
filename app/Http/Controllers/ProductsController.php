<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \App\Product;

class ProductsController extends Controller
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
      $users = User::where('loginUser', 'like', '%'.$param.'%')->paginate(10);
      $request->flash();
    }else{
      $users = User::paginate(10);
    }

    return view('users.index', compact('users') );
  }

}
