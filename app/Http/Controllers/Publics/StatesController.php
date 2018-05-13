<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \App\Models\State;

class StatesController extends Controller
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
  public function byCountry(Request $request)
  {
    $filtro = $request->only( 'idCountry', 'idCountryForeign' );
    if(count($filtro)==0){
      return false;
    }else{
      $state = new State;
      foreach ($filtro as $key => $value) {
        $state = $state->orWhere('idCountry', $value);
      }
    }
    $state = $state->get();

    return \Response::json(compact('state'));
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
      $states = State::where('firstName', 'like', '%'.$param.'%')->paginate(10);
      $request->flash();
    }else{
      $states = State::paginate(10);
    }

    return view('states.index', compact('states') );
  }

  /**
   * Show form create state
   * @return view
   */
  public function create()
  {
    $countrys = \App\Models\Country::all();
    $civilStates = \App\Traits\ConstantPeople::getCivilStates();
  	return view('states.add', compact( [ 'countrys' , 'civilStates' ] ));
  }

  /**
   * Show form edit state
   * @param  Integer $id
   * @return view
   */
  public function edit($id)
  {
      $state = State::find($id);
      return view('states.edit', compact('state'));
  }

  /**
   * validate new state, to use ajax
   * @param  Request $request
   * @return json errors
   */

  public function validateNewDuplicated(Request $request){
    return \Response::json( $this->validate($request, [
        'emailUser' => 'required|string|email|max:255|unique:pgsql_security.tUsers',
        'loginUser' => 'required|string|min:4|max:20|unique:pgsql_security.tUsers',
    ], [
        'emailUser.required' => 'El email es requerido',
        'emailUser.unique'   => 'Este email ya está registrado.',
        'loginUser.required' => 'El rating es requerido',
        'loginUser.unique' => 'Este User ya está registrado',
    ]) ) ;

  }


  /**
   * Save new state
   * @param  Request $request
   * @return Array of errors or redirect to view states.add
   */
  public function store(Request $request)
  {
      //dd($request->file('avatar'));
      $state = new State;
      $this->validate($request, [
          'emailUser' => 'required|string|email|max:255|unique:pgsql_security.tUsers',
          'loginUser' => 'required|string|min:4|max:20|unique:pgsql_security.tUsers',
          'claveUser' => 'required|string|min:6|confirmed',
      ], [
          'emailUser.required' => 'El email es requerido',
          'emailUser.unique'   => 'Este email ya está registrado.',
          'loginUser.required' => 'El login es requerido',
          'loginUser.unique' => 'Este User ya está registrado',
          'claveUser.required' => 'La Clave es requerida',
          'claveUser.confirmed' => 'Las claves no coinciden',
      ]);

      if($request->file('avatar')){
          $file = $request->file('avatar');
          $path = $file->store('avatars', 'public');
          $state->avatar = $path;
      }

      $state->emailUser = $request->input('emailUser');
      $state->loginUser = $request->input('loginUser');
      $state->claveUser = password_hash($request->input('claveUser'), PASSWORD_DEFAULT);

      $state->save();

      return redirect( route('states.index') );
  }


  /**
   * Save an state
   * @param  Request $request
   * @return Array of errors or redirect to view states.edit
   */
  public function update(Request $request)
  {
      $state = new State;
      $this->validate($request, [
          'emailUser' => 'required|string|email|max:255|unique:pgsql_security.tUsers',
          'loginUser' => 'required|string|min:4|max:20|unique:pgsql_security.tUsers',
          'claveUser' => 'required|string|min:6|confirmed',
      ], [
          'emailUser.required' => 'El email es requerido',
          'emailUser.unique'   => 'Este email ya está registrado.',
          'loginUser.required' => 'El rating es requerido',
          'loginUser.unique' => 'Este User ya está registrado',
          'claveUser.required' => 'La Clave es requerida',
          'claveUser.confirmed' => 'Las claves no coinciden',
      ]);

      $state->emailUser = $request->input('emailUser');
      $state->loginUser = $request->input('loginUser');
      $state->claveUser = password_hash($request->input('claveUser'), PASSWORD_DEFAULT);

      $state->save();

      return redirect( route('states') );
  }



}
