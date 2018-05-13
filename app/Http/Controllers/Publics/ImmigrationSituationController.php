<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \App\Models\ImmigrationSituation;

class ImmigrationSituationController extends Controller
{
  /**
   * find a ImmigrationSituation
   * @param by idImmigrationSituation
   * @return json object or false
   */
  public function jsonById(Request $request)
  {
    $filtro = $request->only( 'idImmigrationSituation' );
    if(count($filtro)==0){
      return false;
    }else{
      $list = new ImmigrationSituation;
      foreach ($filtro as $key => $value) {
        $list = $list->orWhere($key, $value);
      }
    }
    $value = $list->first();

    return \Response::json(compact('value'));
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
      $lists = $list::where('firstName', 'like', '%'.$param.'%')->paginate(10);
      $request->flash();
    }else{
      $lists = $list::paginate(10);
    }

    return view('lists.index', compact('lists') );
  }

  /**
   * Show form create list
   * @return view
   */
  public function create()
  {
    $countrys = \App\Models\Country::all();
    $civillists = \App\Traits\ConstantPeople::getCivillists();
  	return view('lists.add', compact( [ 'countrys' , 'civillists' ] ));
  }

  /**
   * Show form edit list
   * @param  Integer $id
   * @return view
   */
  public function edit($id)
  {
      $list = $list::find($id);
      return view('lists.edit', compact('list'));
  }

  /**
   * validate new list, to use ajax
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
   * Save new list
   * @param  Request $request
   * @return Array of errors or redirect to view lists.add
   */
  public function store(Request $request)
  {
      //dd($request->file('avatar'));
      $list = new ImmigrationSituation;
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
          $list->avatar = $path;
      }

      $list->emailUser = $request->input('emailUser');
      $list->loginUser = $request->input('loginUser');
      $list->claveUser = password_hash($request->input('claveUser'), PASSWORD_DEFAULT);

      $list->save();

      return redirect( route('lists.index') );
  }


  /**
   * Save an list
   * @param  Request $request
   * @return Array of errors or redirect to view lists.edit
   */
  public function update(Request $request)
  {
      $list = new ImmigrationSituation;
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

      $list->emailUser = $request->input('emailUser');
      $list->loginUser = $request->input('loginUser');
      $list->claveUser = password_hash($request->input('claveUser'), PASSWORD_DEFAULT);

      $list->save();

      return redirect( route('lists') );
  }



}
