<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pedidos;
use App\Models\Productos;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use ZipArchive;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Productos::all();
        return view('productos.index',
            ["productos" => $productos]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Productos::find($id);
        return view(
            'productos.update',[
                'producto' => $producto
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $producto = Productos::find($request->input('id'));
        $producto->sku = $request->input("sku");
        $producto->descripcion = $request->input("descripcion");
        $producto->unidad_medida = $request->input("unidad_medida");
        $producto->precio = $request->input("precio");
        $producto->unidades_disponibles = $request->input("unidades_disponibles");
        if ($producto->save()){
            return redirect()->route('productos.index')->with('success', 'Se actualizo los datos del producto');
        }else{
            return redirect()->route('productos.index')->with('error', 'Error inesperado al actualizar');
        }
    }

    public function save(Request $request)
    {
        $producto = new Productos;
        $producto['sku'] = $request->input("sku");
        $producto['descripcion'] = $request->input("descripcion");
        $producto['unidad_medida'] = $request->input("unidad_medida");
        $producto['precio'] = $request->input("precio");
        $producto['unidades_disponibles'] = $request->input("unidades_disponibles");
        if ($producto->save()){
            return redirect()->route('productos.index')->with('success', 'Se actualizo los datos del producto');
        }else{
            return redirect()->route('productos.index')->with('error', 'Error inesperado al actualizar');
        }
    }

    public function xml($id = null)
    {
        $id_pedido = $id;
        $pedido = Pedidos::with('clientes', 'usuarios', 'envios')->where('id', $id_pedido)->first();
        $productos = Productos::all();
        $fecha = date("Y-m-d", strtotime($pedido['created_at']));
        $i = 1;

        $id_productos = json_decode($pedido['id_productos']);

        $zip = new ZipArchive;
        $nombreZip = "productos-pedido$id_pedido.zip";
        $rutaZip = storage_path('pedido/' . $id_pedido . "/" . $nombreZip);
        if (!file_exists(storage_path('pedido/' . $id_pedido))) {
            mkdir(storage_path('pedido/' . $id_pedido), 0755, true);
        }
        if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {

            foreach ($id_productos as $key => $item) {
                $cantidad = $item->cantidad;
                foreach ($productos as $j => $producto) {
                    if ($item->id_producto == $producto['id']) {
                        $sku = $producto['sku'];
                        $descripcion = $producto['descripcion'];
                        $precio = $producto['precio'];
                        $total_unidades = $producto['unidades_disponibles'];
                    }
                }
                for ($k = 0; $k < $cantidad; $k++) {

                    $xml = new DOMDocument('1.0', 'UTF-8');

                    // Crear el elemento raíz <DRDataTransfer>
                    $drDataTransfer = $xml->createElement('DRDataTransfer');
                    $xml->appendChild($drDataTransfer);

                    // Crear el elemento <Customer> y sus hijos
                    $customer = $xml->createElement('Customer');
                    $drDataTransfer->appendChild($customer);

                    $customerNumber = $xml->createElement('Number', $pedido['id_cliente']);
                    $customer->appendChild($customerNumber);

                    $customerName = $xml->createElement('Name', $pedido['clientes']['nombre']);
                    $customer->appendChild($customerName);

                    $addresses = $xml->createElement('Addresses');
                    $customer->appendChild($addresses);

                    $address = $xml->createElement('Address');
                    $address->setAttribute('Code', $pedido['id_direccion_envio']);
                    $address->setAttribute('Description', $pedido['envios']['nombre']);
                    $address->setAttribute('PostalCode', $pedido['envios']['codigo_postal']);
                    $address->setAttribute('Address1', $pedido['envios']['direccion']);
                    $addresses->appendChild($address);

                    // Crear el elemento <Article> y sus hijos
                    $article = $xml->createElement('Article');
                    $drDataTransfer->appendChild($article);

                    $articleNumber = $xml->createElement('Number', $sku);
                    $article->appendChild($articleNumber);

                    $articleDescription = $xml->createElement('Description', $descripcion);
                    $article->appendChild($articleDescription);

                    $articleSalesPrice = $xml->createElement('SalesPrice', $precio);
                    $article->appendChild($articleSalesPrice);

                    // Crear el elemento <Order> y sus hijos
                    $order = $xml->createElement('Order');
                    $drDataTransfer->appendChild($order);

                    $transaction = $xml->createElement('Transaction', '0');
                    $order->appendChild($transaction);

                    $orderNumber = $xml->createElement('OrderNumber', $id_pedido);
                    $order->appendChild($orderNumber);

                    $partNumber = $xml->createElement('PartNumber', str_pad($i, 2, "0", STR_PAD_LEFT));
                    $order->appendChild($partNumber);

                    $orderedQuantity = $xml->createElement('OrderedQuantity', $total_unidades);
                    $order->appendChild($orderedQuantity);

                    $dueDate = $xml->createElement('DueDate', $fecha);
                    $order->appendChild($dueDate);

                    // Formatear el XML para que sea legible
                    $xml->formatOutput = true;

                    // Guardar el documento XML en un archivo
                    $xmlString = $xml->saveXML();
                    $filePath = storage_path("pedido/$id_pedido/Pedido$id_pedido " . str_pad($i, 2, "0", STR_PAD_LEFT) . ".xml");
                    file_put_contents($filePath, $xmlString);
                    if (file_exists($filePath)) {
                        $zip->addFile($filePath, "Pedido$id_pedido " . str_pad($i, 2, "0", STR_PAD_LEFT) . ".xml");
                    } else {
                        echo "error";
                    }
                    $i++;
                }
            }

            $zip->close();
            return response()->download($rutaZip, $nombreZip, ['Content-Type' => 'application/zip']);
        }
    }
}
