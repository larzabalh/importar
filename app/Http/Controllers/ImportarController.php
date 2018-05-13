<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use DB;
use App\Models\Person;
use App\Http\Controllers\Controller;
use Excel;

class ImportarController extends Controller
{

   


    public function index()
    {
        $persons =DB::table('persons')
          ->select('persons.*')
            ->get();
                
        return view('persons.importar')
        ->with('persons', $persons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function persons(Request $request)
    {

       $archivo = $request->file('archivo');
       $nombre_original=$archivo->getClientOriginalName();
       $extension=$archivo->getClientOriginalExtension();
       $r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );
       $ruta  =  storage_path('archivos') ."/". $nombre_original;
       
       if($r1){
            $ct=0;
            Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) {
                $hoja->each(function($fila) {
                   
                        $person=new Person;
                        $person->document_type= $fila->document_type;
                        $person->document= $fila->document;
                        $person->field_name1= $fila->field_name1;
                        $person->state_id= $fila->state_id;
                        $person->zone_id= $fila->zone_id;
                        $person->person_type_id= $fila->person_type_id;
                        $person->save();
                });
            });

            return response()->json(["data"=> "TERMINADO"]);
        
       }
       else
       {
            return response()->json(["data"=> 'Error al subir el archivo']);
            
       }

    }


        public function gastos(Request $request)
    {
       $archivo = $request->file('archivo');
       $nombre_original=$archivo->getClientOriginalName();
       $extension=$archivo->getClientOriginalExtension();
       $r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );
       $ruta  =  storage_path('archivos') ."/". $nombre_original;
       
       if($r1){
            $ct=0;
            Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) {
                $hoja->each(function($fila) {
                   
                        $medios=new Gasto;
                        $medios->user_id= auth()->user()->id;
                        $medios->gasto= $fila->gasto;
                        $medios->tipo_de_gasto_id= $fila->tipo_de_gasto_id;
                        $medios->save();
                });
            });

            return response()->json(["data"=> "TERMINADO"]);
        
       }
       else
       {
            return response()->json(["data"=> 'Error al subir el archivo']);
            
       }

    }


    public function bancos(Request $request)
    {
       $archivo = $request->file('archivo');
       $nombre_original=$archivo->getClientOriginalName();
       $extension=$archivo->getClientOriginalExtension();
       $r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );
       $ruta  =  storage_path('archivos') ."/". $nombre_original;
       
       if($r1){
            $ct=0;
            Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) {
                $hoja->each(function($fila) {
                   
                        $medios=new Medios;
                        $medios->user_id= auth()->user()->id;
                        $medios->nombre= $fila->nombre;
                        $medios->save();
                });
            });

            return response()->json(["data"=> "TERMINADO"]);
        
       }
       else
       {
            return response()->json(["data"=> 'Error al subir el archivo']);
            
       }

    }

    public function clientes(Request $request)
    {
       $archivo = $request->file('archivo');
       $nombre_original=$archivo->getClientOriginalName();
       $extension=$archivo->getClientOriginalExtension();
       $r1=Storage::disk('archivos')->put($nombre_original,  \File::get($archivo) );
       $ruta  =  storage_path('archivos') ."/". $nombre_original;
       
       if($r1){
            $ct=0;
            Excel::selectSheetsByIndex(0)->load($ruta, function($hoja) {
                $hoja->each(function($fila) {
                   
                        $clientes=new Cliente;
                        $clientes->user_id= auth()->user()->id;
                        $clientes->cliente= $fila->cliente;
                        $clientes->honorario= $fila->honorario;
                        $clientes->email= $fila->email;
                        $clientes->facturador_id= $fila->facturador_id;
                        $clientes->liquidador_id    = $fila->liquidador_id  ;
                        $clientes->cobrador_id= $fila->cobrador_id;
                        $clientes->disponibilidad_id= $fila->disponibilidad_id;
                        $clientes->contacto= $fila->contacto;
                        $clientes->comentario= $fila->comentario;
                        $clientes->save();
                });
            });

            return response()->json(["data"=> "TERMINADO"]);
        
       }
       else
       {
            return response()->json(["data"=> 'Error al subir el archivo']);
            
       }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
