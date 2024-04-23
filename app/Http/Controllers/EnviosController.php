<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Envios;
use Illuminate\Http\Request;

class EnviosController extends Controller
{
    public function index(){
        $envios = Envios::with('clientes')->get();
        return view('envios.index', [
            'envios' => $envios
        ]);
    }

    public function show(string $id){
        $envio = Envios::find($id);
        return view('envios.update', [
            "envio" => $envio
        ]);
    }

    public function create(){
        $clientes = Clientes::all();
        return view('envios.create', [
            'clientes' => $clientes
        ]);
    }

    public function save(Request $request){
        $envio = new Envios;
        $envio->id_cliente = $request->input('id_cliente');
        $envio->nombre = $request->input('nombre');
        $envio->direccion = $request->input('direccion');
        $envio->codigo_postal = $request->input('codigo_postal');
        $envio->contacto = $request->input('contacto');
        $envio->telefono = $request->input('telefono');
        if ($envio->save()){
            return redirect()->route('envios.index')->with('success', 'Se creo correctamente el envio');
        }else{
            return redirect()->route('envios.index')->with('error', 'Error inesperado al actualizar');
        }
    }

    public function get(Request $request, $id = null){
        $direccion_envios = Envios::where('id_cliente', $id)->get();
        $data = [];

        foreach ($direccion_envios as $key => $direccion) {
            array_push($data, [
                'id' => $direccion['id'],
                'text' => $direccion['direccion'].", ".$direccion['codigo_postal'].". Contacto: ".$direccion['contacto']." ".$direccion['telefono']
            ]);
        }

        return json_encode($data);
    }

    public function update(Request $request){

        $direccion = Envios::find($request->input('id_direccion_envio'));
        $direccion['nombre'] = $request->input('nombre');
        $direccion['direccion'] = $request->input('direccion');
        $direccion['codigo_postal'] = $request->input('codigo_postal');
        $direccion['telefono'] = $request->input('telefono');
        $direccion['contacto'] = $request->input('contacto');
        $direccion->save();

        $log = new LogController();
        $log->create(
            Auth()->user()->id,
            json_encode([
                'detalles' => 'Actualizacion de datos de envio',
                'payload' => $direccion
            ])
        );
        return redirect()->route('envios.index')->with('success', 'Se actualizo los datos de envío');
    }
}
