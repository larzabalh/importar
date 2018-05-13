<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use \App\Models\PersonalFile;
use \App\Models\ForeignFile;
use \App\Models\ImmigrationSituation;

use \App\Http\Requests\ContactCreateRequest;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PersonalFileController extends Controller
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
      $personalfile = PersonalFile::where('firstName', 'like', '%'.$param.'%')
      ->paginate(10);
      $request->flash();
    }else{
      $personalfile = PersonalFile::paginate(10);
    }
    return view('personalfile.index', compact('personalfile') );
  }

  /**
   * Show form create personalFile
   * @return view
   */
  public function create(Request $request)
  {
    $countrys = \App\Models\Country::orderBy('countryName', 'asc')->get();
    $civilStates = \App\Traits\ConstantPeople::getCivilStates();
    $instruccionDegrees = \App\Traits\ConstantPeople::getIntruccionDegrees();
    $states = \App\Models\State::where('idCountry', 95)->get();
    $statesForeigns = \App\Models\State::where('idCountry', 5)->get();
    $immigrationSituations = ImmigrationSituation::all();
    $bloodTypes = \App\Traits\ConstantPeople::getBloodTypes();
  	return view('personalfile.form', compact(
      [ 'countrys', 'civilStates', 'states', 'personalFile', 'foreignFile',
    'statesForeigns', 'immigrationSituations', 'instruccionDegrees',
    'bloodTypes' ] ));
  }

  /**
   * Show form edit personalFile
   * @param  Integer $id
   * @return view
   */
  public function edit($id)
  {
      $personalFile = PersonalFile::findOrFail($id);
      //dd($personalFile);
      $foreignFile = ForeignFile::where('idPersonalFile', '=', $id)->first();
      //dd($foreignFile);
      if(count($foreignFile)==0){ unset($foreignFile); }
      $countrys = \App\Models\Country::orderBy('countryName', 'asc')->get();
      $civilStates = \App\Traits\ConstantPeople::getCivilStates();
      $instruccionDegrees = \App\Traits\ConstantPeople::getIntruccionDegrees();

      $states = \App\Models\State::where('idCountry', '=',
       $personalFile['idCountry'])->get();
      $statesForeigns = \App\Models\State::where('idCountry',
       (isset($foreignFile->idCountry)?$foreignFile->idCountry:5))->get();
      $immigrationSituations = ImmigrationSituation::all();
      $bloodTypes = \App\Traits\ConstantPeople::getBloodTypes();

      return view('personalfile.form', compact(
        ['countrys', 'civilStates', 'states', 'personalFile', 'foreignFile',
      'statesForeigns', 'immigrationSituations', 'instruccionDegrees',
      'bloodTypes' ]));
  }



  /**
   * find a personalFile
   * @param by idCountry and personalID
   * @return json object or false
   */
  public function findByPersonalID(Request $request)
  {
    $filtro = $request->only( 'personalID','idCountry');
    //return json_encode($filtro);
    if(count($filtro)==0){
      return false;
    }else{
      $personalFile = new PersonalFile;
      $personalFile = $personalFile->select(
        'idPersonalFile', 'firstName', 'lastName', 'personalID')->where(
        [ ['personalID', '=', $filtro['personalID'] ],
          ['idCountry', '=', $filtro['idCountry'] ]
        ]
      )->first();
      return(\Response::json(compact('personalFile')));
    }
  }

  /**
   * find a foreignFile
   * @param by idCountry and personalID
   * @return json object or false
   */
  public function findByForeignID(Request $request)
  {
    $filtro = $request->only( 'personalID','idCountry');
    //return json_encode($filtro);
    if(count($filtro)==0){
      return false;
    }else{
      $foreignFile = new ForeignFile;
      $foreignFile = $foreignFile->select(
        'idPersonalFile', 'idForeignFile', 'idCountry', 'personalID')->where(
        [ ['personalID', '=', $filtro['personalID'] ],
          ['idCountry', '=', $filtro['idCountry'] ]
        ]
      )->first();
      return(\Response::json(compact('foreignFile')));
    }
  }

  /**
   * validate new personalFile, to use ajax
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
   * Save new personalFile
   * @param  Request $request
   * @return Array of errors or redirect to view personalfile.form
   */
  public function storePersonalFile(Request $request)
  {
      //dd($request->all());
      $idCountry = $request->input("idCountry");
      $personalID = $request->input('personalID');

      $this->validate($request, [
          'idCountry' => 'required|unique:pgsql_people.tPersonalFiles,idCountry,NULL,idPersonalFile,personalID,'.$personalID.'',
          'officialGazette' => 'required_with:naturalized',
          'officialGazetteDate' => 'required_with:naturalized|date',
          'personalID' => 'required|numeric|digits_between:4,9|unique:pgsql_people.tPersonalFiles,personalID,NULL,idPersonalFile,idCountry,'.$idCountry.'',
          'emisionPersonalID' => 'nullable|date',
          'expirationPersonalID' => 'nullable|date',
          'gender' => 'required',
          'firstName' => 'required|string',
          'lastName' => 'required|string',
          'birthDate' => 'required|date',
          'birthPlace' => 'required',
          'passportNumber' => 'required|numeric|digits_between:6,18',
          'emisionPassport' => 'required|date',
          'expirationPassport' => 'required|date',
          'civilState' => 'required',
          'idState' => 'required',
          'addressOrigin' => 'required|string',
          'principalEmail' => 'required|email',
          'secondaryEmail' => 'nullable|email',
          'birthFileDate' => 'nullable|date',
      ], [
          'personalID.unique'   => 'Esta Cédula ya está registrada',
          'required' => 'Campo requerido',
          'date' => 'Fecha inválida',
          'string' => 'Debe ser numero y letras',
          'email' => 'Email inválido',
          'numeric' => 'Debe ser un número',
          'digits_between' => 'Un mínimo de :min y máximo :max'
      ]);

      $data =$request->all();
      $data['idUserModified'] = Auth::User()->idField();
      $data['pensionerIVSS'] = isset($data['pensionerIVSS'])
                ? $data['pensionerIVSS'] : '0';
      if (isset($data['naturalized'])){
        $data['naturalized'] = $data['naturalized'];
      }else{
        $data['naturalized'] = 0;
        $data['officialGazette'] = '';
        $data['officialGazetteDate']='';
        $data['officialGazetteDate'] = strlen($data['officialGazetteDate'])
          ? Carbon::createFromFormat('d/m/Y', $data['officialGazetteDate']) : null;
      }

      $personalFile = PersonalFile::create( $data );
      //print_r($personalFile);
      //die;
      return redirect()
        ->route('personalfile.edit', ['id' => $personalFile->idField() ])
        ->with('statusPF', 'Ficha Registrada!');
      //return redirect( route('personalfile.edit') );
  }


  /**
   * Save an personalFile
   * @param  Request $request
   * @return Array of errors or redirect to view personalfile.edit
   */
  public function updatePF( Request $request )
  {
    $id=key($request->query());
    $personalFile = PersonalFile::findOrFail($id);

    $idCountry = $request->input("idCountry");
    $personalID = $request->input('personalID');

    $this->validate($request, [
      'idCountry' => 'required|unique:pgsql_people.tPersonalFiles,idCountry,'.$id.',idPersonalFile,personalID,'.$personalID.'',
      'officialGazette' => 'required_with:naturalized',
      'officialGazetteDate' => 'required_with:naturalized|date',
      'personalID' => 'required|numeric|digits_between:4,9|unique:pgsql_people.tPersonalFiles,personalID,'.$id.',idPersonalFile,idCountry,'.$idCountry.'',
      'emisionPersonalID' => 'nullable|date',
      'expirationPersonalID' => 'nullable|date',
      'firstName' => 'required|string',
      'lastName' => 'required|string',
      'birthDate' => 'required|date',
      'birthPlace' => 'required',
      'passportNumber' => 'required|numeric|digits_between:6,18',
      'emisionPassport' => 'required|date',
      'expirationPassport' => 'required|date',
      'civilState' => 'required',
      'idState' => 'required',
      'addressOrigin' => 'required|string',
      'principalEmail' => 'required|email',
      'secondaryEmail' => 'nullable|email',
      'birthFileDate' => 'nullable|date'
    ], [
      'personalID.unique'   => 'Esta Cédula ya está registrada',
      'required' => 'Campo requerido',
      'date' => 'Fecha inválida',
      'string' => 'Debe ser numero y letras',
      'email' => 'Email inválido',
      'numeric' => 'Debe ser un número',
      'digits_between' => 'Un mínimo de :min y máximo :max'
    ]);
    //dd($request->except($id));
    $data =$request->all();
    $data['idUserModified'] = Auth::User()->idField();
    $data['pensionerIVSS'] = isset($data['pensionerIVSS'])
              ? $data['pensionerIVSS'] : '0';
    if (isset($data['naturalized'])){
      $data['naturalized'] = $data['naturalized'];
    }else{
      $data['naturalized'] = 0;
      $data['officialGazette'] = '';
      $data['officialGazetteDate']='';
      $data['officialGazetteDate'] = strlen($data['officialGazetteDate'])
        ? Carbon::createFromFormat('d/m/Y', $data['officialGazetteDate']) : null;
    }
    $personalFile->update( $data );


    return redirect()
      ->route('personalfile.edit', ['id' => $personalFile->idField()  ])
      ->with('statusPF', 'Ficha Actualizada!');
  }




  /**
   * Now save the foreignFile   ***************************************
   *
   */

   /**
    * Save new personalFile
    * @param  Request $request
    * @return Array of errors or redirect to view personalfile.form
    */
   public function storeForeignFile(Request $request)
   {
     $idCountry = $request->input("idCountry");
     $personalID = $request->input('personalID');

     //d($request->all());
     $this->validate($request, [
         'idCountry' => 'required|unique:pgsql_people.tForeignFiles,idCountry,NULL,idForeignFile,personalID,'.$personalID,
         'personalID' => 'required_without_all:alternativePersonalID|unique:pgsql_people.tForeignFiles,personalID,NULL,idForeignFile,idCountry,'.$idCountry,
         'emisionPersonalID' => 'nullable|date',
         'expirationPersonalID' => 'nullable|date',
         'alternativePersonalID' => 'required_without_all:personalID',
         'idState' => 'required',
         'addressForeign' => 'required|string',
         'localPhoneNumber' => 'nullable|string',
         'mobilePhoneNumber' => 'nullable|string',
         'dateIn' => 'nullable|date'
     ], [
         'idCountry.unique' => 'Este documento ya está registrado',
         'personalID.unique' => 'Este documento ya está registrado',
         'required_without_all' => 'Debe de estar lleno',
         'required' => 'Campo requerido',
         'date' => 'Fecha inválida',
         'string' => 'Debe ser numero y letras'
     ]);
     $data =$request->all();
     $data['idUserModified'] = Auth::User()->idField();

     if (isset($data['hasSentence'])){
       $data['hasSentence'] = $data['hasSentence'];
       $data['studyDescription'] = '';
     }else{
       $data['hasSentence'] = 0;
       $data['sentenceDescription'] = '';
       $data['sentenceTo']='';
       $data['sentenceTo'] = strlen($data['sentenceTo'])
         ? Carbon::createFromFormat('d/m/Y', $data['sentenceTo']) : null;
       $data['sentenceFrom']='';
       $data['sentenceFrom'] = strlen($data['sentenceFrom'])
         ? Carbon::createFromFormat('d/m/Y', $data['sentenceFrom']) : null;
     }

     $foreignFile = ForeignFile::create( $data );
     //dd($foreignFile);
     //print_r($personalFile);
     //die;
     return redirect()->route('personalfile.edit',
      ['id' => $request->idPersonalFile ])
      ->with('statusFF', 'Datos Argentinos Guardados!');
     //return redirect( route('personalfile.edit') );
   }


   /**
    * Save an personalFile
    * @param  Request $request
    * @return Array of errors or redirect to view personalfile.edit
    */
   public function updateFF( Request $request )
   {
     //dd($request->query());
     $id=key($request->query());
     $foreignFile = ForeignFile::findOrFail($id);
     $idCountry = $request->input("idCountry");
     $personalID = $request->input('personalID');
     $this->validate($request, [
       'idCountry' => 'required|unique:pgsql_people.tForeignFiles,idCountry,'.$id.',idForeignFile,personalID,'.$personalID,
       'personalID' => 'required_without_all:alternativePersonalID|unique:pgsql_people.tForeignFiles,personalID,'.$id.',idForeignFile,idCountry,'.$idCountry,
       'emisionPersonalID' => 'nullable|date',
       'expirationPersonalID' => 'nullable|date',
       'alternativePersonalID' => 'required_without_all:personalID',
       'idState' => 'required',
       'addressForeign' => 'required|string',
       'localPhoneNumber' => 'nullable|string',
       'mobilePhoneNumber' => 'nullable|string',
       'dateIn' => 'nullable|date'
     ], [
       'personalID.unique' => 'Este documento ya está registrado',
       'required_without_all' => 'Debe de estar lleno',
       'required' => 'Campo requerido',
       'date' => 'Fecha inválida',
       'string' => 'Debe ser numero y letras'
     ]);
     //dd($request->except($id));
     $data =$request->all();

     if (isset($data['hasSentence'])){
       $data['hasSentence'] = $data['hasSentence'];
       $data['studyDescription'] = '';
     }else{
       $data['hasSentence'] = 0;
       $data['sentenceDescription'] = '';
       $data['sentenceTo']='';
       $data['sentenceTo'] = strlen($data['sentenceTo'])
         ? Carbon::createFromFormat('d/m/Y', $data['sentenceTo']) : null;
       $data['sentenceFrom']='';
       $data['sentenceFrom'] = strlen($data['sentenceFrom'])
         ? Carbon::createFromFormat('d/m/Y', $data['sentenceFrom']) : null;
     }

     $foreignFile->idUserModified = Auth::User()->idField();
     $foreignFile->update( $data );

     return redirect()->route('personalfile.edit',
      ['id' => $request->idPersonalFile ])
      ->with('statusFF', 'Datos Argentinos Guardados!');
   }



   /**
    * Save new contact
    * @param  Request $request
    * @return Array of errors or redirect json errors
    */
   public function storeContact(ContactCreateRequest $request)
   {
     //implicitamente se procesa el Request del Create Contact

     //*****Validar si en ForeignFile el idCountry y personalID

     $data =$request->all();
     $data['addressOrigin'] = $data['addressContact'];
     $data['idUserModified'] = Auth::User()->idField();

     $data['pensionerIVSS'] = isset($data['pensionerIVSS'])
               ? $data['pensionerIVSS'] : '0';
     if (isset($data['naturalized'])){
       $data['naturalized'] = $data['naturalized'];
     }else{
       $data['naturalized'] = 0;
       $data['officialGazette'] = '';
       $data['officialGazetteDate']='';
       $data['officialGazetteDate'] = strlen($data['officialGazetteDate'])
         ? Carbon::createFromFormat('d/m/Y', $data['officialGazetteDate']) : null;
     }

     //*****Averiguar las transacciones para que se guarden en las tres tablas
     //*****************Claro está si es necesario

     //$personalFile = PersonalFile::create( $data );

     //*******Registrar el ForeignFile para los que no son Argentinos o el Pais Actual


     //****Registrar en contacto en la tabla de los contactos

     //print_r($personalFile);
     //die;
     $personalFile = [$request->all()];
     return(\Response::json(compact('personalFile')));
     //return redirect( route('personalfile.edit') );
   }



}
