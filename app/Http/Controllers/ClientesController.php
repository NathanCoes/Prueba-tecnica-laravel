<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Envios;
use App\Models\Pedidos;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function index(){
        $clientes = Clientes::all();
        return view('clientes.index', [
            'clientes'=> $clientes
        ]);
    }

    public function show($id = null){
        $cliente = Clientes::find($id);

        return view('clientes.update', ["cliente" => $cliente]);
    }

    public function delete($id = null){
        $cliente = Clientes::find($id);
        $direcciones = Envios::where('id_cliente', $cliente->id)->get();
        $pedidos = Pedidos::where('id_cliente', $cliente->id)->get();
        foreach ($direcciones as $key => $value) {
            $direccion = new Envios;
            $direccion = $direcciones[$key];
            $direccion->id_cliente = 1;
            $direccion->save();
        }
        foreach ($pedidos as $key => $value) {
            $pedido = new Pedidos;
            $pedido = $pedidos[$key];
            $pedido->id_cliente = 1;
            $pedido->save();
        }

        $cliente->delete();

        return redirect()->route('clientes.index')->with(['success' => "Se borro con exito el cliente"]);
    }

    public function create(){
        return view("clientes.create");
    }

    public function save(Request $request){
        $cliente = new Clientes;
        $cliente['nombre'] = $request->input('nombre');
        $cliente['rfc'] = $request->input('rfc');
        $cliente['email'] = $request->input('email');
        $cliente['telefono'] = $request->input('telefono');
        $cliente['contacto'] = $request->input('contacto');
        $cliente->save();
        return redirect()->route('clientes.index')->with(['success' => "Se agregado con exito el cliente"]);
    }

    public function update(Request $request){

        $cliente = Clientes::find($request->input('id_cliente'));
        $cliente['nombre'] = $request->input('nombre');
        $cliente['rfc'] = $request->input('rfc');
        $cliente['email'] = $request->input('email');
        $cliente['telefono'] = $request->input('telefono');
        $cliente['contacto'] = $request->input('contacto');
        $cliente->save();

        $log = new LogController();
        $log->create(
            Auth()->user()->id,
            json_encode([
                'detalles' => 'Actualizacion de datos del cliente',
                'payload' => $cliente
            ])
        );
        return redirect()->route('clientes.index')->with('success', 'Se actualizo los datos del cliente');
    }
}
