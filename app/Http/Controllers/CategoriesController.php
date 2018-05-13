<?php

namespace App\Http\Controllers;

use App\Categorie;
use Illuminate\Http\Request;

class CategoriesController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $param = isset($request['param']) ? $request['param'] : null ;
      if($param){
        $categories = Categorie::where('nameCategorie', 'like', '%'.$param.'%')->paginate(10);
        $request->flash();
      }else{
        $categories = Categorie::paginate(10);
      }
      //dd($categories);
      return view('categories.index', compact('categories') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.add');
    }


    /**
     * validate new categorie, to use ajax
     * @param  Request $request
     * @return json errors
     */

    public function validateNewDuplicated(Request $request){
      return \Response::json( $this->validate($request, [
          'nameCategorie' => 'required|string|max:255|unique:pgsql_inventory.tCategories',
      ], [
          'nameCategorie.required' => 'El Nombre es requerido',
          'nameCategorie.unique'   => 'Ya está registrado.',
      ]) ) ;

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //dd($request->file('avatar'));
      $categorie = new Categorie;
      $this->validate($request, [
          'nameCategorie' => 'required|string|max:255|unique:pgsql_inventory.tCategories',
      ], [
          'nameCategorie.required' => 'El Nombre es requerido',
          'nameCategorie.unique'   => 'Ya está registrado.',
      ]);

      $categorie->nameCategorie = $request->input('nameCategorie');

      $categorie->save();

      return redirect( route('categories.index') );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $categorie = Categorie::find($id);
      return view('categories.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categorie $categorie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categorie  $categorie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categorie $categorie)
    {
        //
    }
}
