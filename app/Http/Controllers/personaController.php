<?php

namespace App\Http\Controllers;

//Lo siguiente sale en el video, se lo puso por default
//use App/Http/Controllers/Controller
use Illuminate\Http\Request;
use App\Persona;
use Illuminate\Support\Facades\Validator;

class personaController extends Controller
{
    public function list(){
        $personas = Persona::all();
        if($personas->isEmpty()){
            return response()->json(['message' => 'No hay personas registradas'], 404);
        }
        return response()->json($personas, 200);
    }

    public function listOne($id){
        $persona = Persona::find($id);
        if(!$persona){
            //Retorno en caso de que no se encuentre el id en la bd
            return response()->json([
                'message' => 'Persona no encontrada',
            ], 404);
        }
        return response()->json([$persona],200);
    }
    
    public function create(Request $request){
        //Validación de los campos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellidos' => 'required'
        ]);
        //Comprobación de la validación 
        if($validator->fails()){
            //Retorno en caso de que falle la validación
            return response()->json(
                [
                    'message' => 'Error en la validación de los datos',
                    'errors' => $validator->errors()
                ], 404
            );
        }
        //Creación de la persona en la bd
        $persona = Persona::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos
        ]);
        //Validación de la creación en la bd
        if(!$persona){
            //Retorno en caso de que falle al guardar en la bd
            return response()->json(
                [
                    'message' => 'Error en la validación de los datos'
                ], 500
            );
        }
        return response()->json([
            'message' => 'Persona creada',
            'persona' => $persona
        ],201);
    }

    public function update(Request $request, $id){
        $persona = Persona::find($id);
        if(!$persona){
            //Retorno en caso de que no se encuentre el id en la bd
            return response()->json([
                'message' => 'Persona no encontrada',
            ], 404);
        }
        //Validación de los campos
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'apellidos' => 'required'
        ]);
        //Comprobación de la validación 
        if($validator->fails()){
            //Retorno en caso de que falle la validación
            return response()->json(
                [
                    'message' => 'Error en la validación de los datos',
                    'errors' => $validator->errors()
                ], 404
            );
        }
        $persona->nombre = $request->nombre;
        $persona->apellidos = $request->apellidos;
        //Se guardan los datos
        $persona->save();
        return response()->json([
            'message' => 'Persona actualizada',
            'persona' => $persona
        ], 201);
    }

    public function delete($id){
        $persona = Persona::find($id);
        if(!$persona){
            //Retorno en caso de que no se encuentre el id en la bd
            return response()->json([
                'message' => 'Persona no encontrada',
            ], 404);
        }
        $persona->delete();
        return response()->json([
            'message' => 'Persona eliminada'
        ],200);
    }

    public function restore($id){
        $persona = Persona::withTrashed()
            ->where('id', $id)
            ->restore();
        return response()->json([
            'message' => 'Persona restaurada'
        ],200);
    }
}
