<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use \App\Models\Relationship;

class RelationshipController extends Controller
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
  public function allRelations(Request $request)
  {
    $relations = Relationship::orderBy('typeRelation', 'asc')
      ->orderBy('nameRelationType', 'asc')->get();

    return \Response::json(compact('relations'));
  }






}
