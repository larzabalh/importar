<?php

namespace App\Http\Controllers\Masters;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Period;
use App\Models\Type;
use App\Models\Person;
use App\Models\IvaCondition;
use App\Models\PersonType;
use App\Models\Zone;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\PersonCreateRequest as PCR;

class PersonsController extends Controller
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
        $list = Person::where('field_name1', 'like', '%'.$param.'%')
        ->orWhere('field_name2', 'like', '%'.$param.'%')
        ->orWhere('document', 'like', '%'.$param.'%')
        ->get();
        //$request->flash();
      }else{
        $list = Person::all();
      }

      return response()->json(["data"=> $list->toArray()]);
    }


    public function getOnlyPersons(Request $request){

      $list = Person::onlyPersons();

      return response()->json(["data"=> $list->toArray()]);
    }


    public function index(Request $request)
    {
      return view('persons.index' );
    }


    public function create( Request $request)
    {
      $documentTypes = Person::getDocumentTypes();
      $ivaConditions = IvaCondition::all();
      $personTypes = PersonType::all();
      $zones = Zone::orderBy('name', 'asc')->get();

      $person = [];
      if($request->route('id')){
        $person = Person::find($request->route('id'));
      }

      return view('persons.form', compact(['documentTypes', 'ivaConditions',
        'personTypes', 'person', 'zones']));
    }

    public function save( PCR $request )
    {
      //return (\Response::json(['respuesta' => $request->all() ] , 400));

      $data = $request->all();
      //0.1 valido los datos (Crear request para el save)
        //Falta la validacion busque solo las empresas con configuraciones

      //1 Creo o Busco el objeto persona y Empresa
        //tabla persons
        if(isset($data['person_id'])){
          $person = Person::find($data['person_id']);
          //return (\Response::json(['respuesta' => 'aqui quede' ] , 400));
          //return (\Response::json(['respuesta' => $personConf ] , 400));
        }else{
          //deberia de buscar a la persona por si es cliente, y asi actualizarla
          //sino creo la persona desde cero.
            $person = new Person;
        }

        //guardo los datos los cambios en arrays por separado.
        $dataPerson['address'] = $data['address']??null;
        $dataPerson['document'] = $data['document'];
        $dataPerson['document_type'] = strtolower($data['document_type']);
        $dataPerson['field_name1'] = $data['field_name1'];
        $dataPerson['state_id'] = $data['zone_id']??null;
        $dataPerson['zone_id'] = $data['zone_id']??null;
        $dataPerson['person_type_id'] = $data['person_type_id']??null;

      //2 entro en la transaccion
      $retorno = \DB::transaction(function () use($data, $dataPerson, $person) {
        //2.1 guardo el objeto persons
        $person->fill($dataPerson);
        $person->save();

        return( ['msj' => 'Guardados Exitosamente' ] );
      });


      return(\Response::json(['respuesta' => $retorno ], 201 ));
    }



}
