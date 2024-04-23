<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Envios;
use App\Models\Pedidos;
use App\Models\Productos;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class PedidosController extends Controller
{
    public function index()
    {
        $pedidos = Pedidos::with('clientes', 'usuarios')->get();

        return view('pedidos.index', [
            'pedidos' => $pedidos,
            'validateStatus' => [$this, 'validateStatus']
        ]);
    }

    public function getInfo(Request $request, $id = null)
    {
        $id_pedido = $id != null
            ? $id
            : $request->input('pedido_id');

        $pedido = Pedidos::with('clientes', 'usuarios', 'envios')->where('id', $id_pedido)->first();
        $productos_id = json_decode($pedido->id_productos);
        $productos = [];
        foreach ($productos_id as $key => $value) {
            $temp = Productos::where('id', $value->id_producto)->first();
            array_push(
                $productos,
                [
                    'cantidad' => $value->cantidad,
                    'detalles' => $temp
                ]
            );
        }

        $allProductos = Productos::all();
        session(['id_pedido' => $id_pedido]);

        if ($pedido) {
            if ($id != null) {
                $clientes = Clientes::all();
                $direcciones_cliente = Envios::all()->where('id_cliente', $pedido['id_cliente']);
                session(['id_pedido' => $id_pedido]);
                return view('pedidos.editar', [
                    "detalles_pedido" => $pedido,
                    "productos" => $productos,
                    "clientes" => $clientes,
                    "direcciones_cliente" => $direcciones_cliente,
                    "allProductos" => $allProductos
                ]);
            } else {
                return response()->json([
                    "detalles_pedido" => $pedido,
                    "productos" => $productos
                ], 200);
            }
        } else {
            return response()->json(['error' => 'Pedido no encontrado'], 404);
        }
    }

    public function update(Request $request)
    {
        $pedido = Pedidos::find(session('id_pedido'));


        if ($request->input('cantidad')){
            $productos = json_decode($pedido['id_productos']);
            foreach ($productos as $key => $producto) {
                if ($producto->id_producto == $request->input('id_producto')) {
                    $productos[$key]->cantidad = $request->input('cantidad');
                }
            }

            $pedido['id_productos'] = json_encode($productos);

            if ($request->input('id_cliente') && $request->input('id_direccion_envio')) {
                $pedido['id_cliente'] = $request->input('id_cliente');
                $pedido['id_direccion_envio'] = $request->input('id_direccion_envio');
            }

            $monto = 0;
            $productosIds = array_column($productos, 'id_producto');
            $productosCollect = Productos::whereIn('id', $productosIds)->get();

            foreach ($productosCollect as $producto) {
                $productoElegido = array_values(array_filter($productos, function($item) use ($producto) {
                    return $item->id_producto == $producto->id;
                }))[0];

                $cantidadElegida = $productoElegido->cantidad ?? 0;
                $monto += $producto->precio * $cantidadElegida;
            }
            $pedido->monto = $monto;
        }else{
            if ($request->input('id_cliente')){
                $direcciones_cliente = Envios::where('id_cliente', $request->input('id_cliente'))->first();
                $pedido['id_cliente'] = $request->input('id_cliente');
                $id_direccion = $direcciones_cliente['id'];
            }
            if ($request->input('id_direccion_envio')){
                $id_direccion = $request->input('id_direccion_envio');
            }
            $pedido['id_direccion_envio'] = $id_direccion;
        }


        if ($pedido->save()) {
            $log = new LogController();
            $log->create(
                Auth()->user()->id,
                json_encode([
                    'detalles' => 'Actualizacion de pedido',
                    'payload' => $pedido
                ])
            );
            return response()->json([
                "success" => "Actualizacion de pedido",
            ], 200);
        }

        return response()->json([
            "error" => "Ah ocurrido un error inesperado al guardar los cambios en el pedido",
        ], 500);
    }

    public function add(Request $request){
        $finded = false;

        $producto = [
            'id_producto' => $request->input('id_producto'),
            'cantidad' => $request->input('cantidad')
        ];

        $pedido = Pedidos::find(session('id_pedido'));

        $id_productos = json_decode($pedido->id_productos);

        foreach ($id_productos as $key => $item) {
            if($item->id_producto == $producto['id_producto']){
                $id_productos[$key]->cantidad += $producto['cantidad'];
                $finded = true;
            }
        }

        if(!$finded){
            //Este paso es para convertir el ultimo valor agregado a un tipo de StdClass para que posteriormente pueda sacarse el monto por el pedido
            array_push($id_productos, json_decode(json_encode($producto)));
        }

        $monto = 0;
        $productosIds = array_column($id_productos, 'id_producto');
        $productos = Productos::whereIn('id', $productosIds)->get();

        foreach ($productos as $producto) {
            $productoElegido = array_values(array_filter($id_productos, function($item) use ($producto) {
                var_dump($item);
                return $item->id_producto == $producto->id;
            }))[0];

            $cantidadElegida = $productoElegido->cantidad ?? 0;
            $monto += $producto->precio * $cantidadElegida;
        }

        $pedido->id_productos = json_encode($id_productos);
        $pedido->monto = $monto;

        try {
            $pedido->save();
            $log = new LogController();
            $log->create(
                Auth()->user()->id,
                json_encode([
                    'detalles' => 'Actualizacion de los productos de un pedido',
                    'payload' => $pedido
                ])
            );
            return redirect()->back()->with(["success" => "Productos actualizados dentro del pedido"]);
        } catch (\Throwable $th) {
            return redirect()->back()->with(["error" => $th]);
        }

        return response()->json([
            "error" => "Ah ocurrido un error inesperado al guardar los cambios en el pedido",
        ], 500);
    }

    public function delete($id = null){
        $pedido = Pedidos::find($id);

        try {
            $pedido->delete();
            $log = new LogController();
            $log->create(
                Auth()->user()->id,
                json_encode([
                    'detalles' => 'Se ha borrado un pedido.',
                    'payload' => $pedido
                ])
            );
            return redirect()->back()->with(['success' => 'Pedido borrado']);
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' =>  $th]);
        }
    }

    public function deleteProducto(Request $request)
    {
        $pedido = Pedidos::find(session('id_pedido'));
        $productos = json_decode($pedido['id_productos']);
        $newProductos = [];

        foreach ($productos as $key => $producto) {
            if ($producto->id_producto != $request->input('id_producto')) {
                array_push($newProductos, $productos[$key]);
            }
        }

        $pedido['id_productos'] = json_encode($newProductos);
        if ($pedido->save()) {
            $log = new LogController();
            $log->create(
                Auth()->user()->id,
                json_encode([
                    'detalles' => 'Actualizacion de los productos de un pedido',
                    'payload' => $pedido
                ])
            );
            return response()->json([
                "success" => "Productos actualizados dentro del pedido",
            ], 200);
        }

        return response()->json([
            "error" => "Ah ocurrido un error inesperado al guardar los cambios en el pedido",
        ], 500);
    }

    public function download(Request $request , $id){
        $pedido = Pedidos::with('clientes', 'usuarios', 'envios')->where('id', $id)->first();
        // echo "<pre>";
        // var_dump($pedido);
        if ($pedido != null){

            $productos_id = json_decode($pedido['id_productos']);
            $productos = [];
            foreach ($productos_id as $key => $value) {
                $temp = Productos::where('id', $value->id_producto)->first();
                array_push(
                    $productos,
                    [
                        'cantidad' => $value->cantidad,
                        'detalles' => $temp
                    ]
                );
            }

            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $options->set('defaultFont', 'Arial');

            $dompdf = new Dompdf($options);

            $html = view("pedidos.nota", [
                'pedido' => $pedido,
                'productos' => $productos
            ])->render();
            $dompdf->loadHtml($html);
            $dompdf->render();

            return redirect()->back()->with(['download' => $dompdf->stream('pedido-'.$pedido['clientes']['nombre']."-".$pedido['id'].".pdf")]);
        }else{
            return redirect()->back()->with(['error'=>'No existe el pedido al cual se le pueda generar una nota.']);
        }
    }

    public function createIndex(){
        $productos = Productos::all();
        $clientes = Clientes::all();

        return view('pedidos.crear', [
            'productos'=> $productos,
            'clientes' => $clientes
        ]);
    }

    public function create(Request $request){
        $pedido = new Pedidos;
        $pedido['id_productos'] = $request->input('id_productos');
        $pedido['monto'] = $request->input('monto');
        $pedido['id_cliente'] = $request->input('cliente');
        $pedido['id_direccion_envio'] = $request->input('envio');
        $pedido['creado_por'] = Auth()->user()->id;
        try {
            $pedido->save();
            $log = new LogController();
            $log->create(
                Auth()->user()->id,
                json_encode([
                    'detalles' => 'Pedido creado',
                    'payload' => $pedido
                ])
            );
            return redirect()->route("pedidos.enlistar")->with([
                "success" => "Pedido creado.",
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with([
                "error" => $th,
            ]);
        }
    }
}
