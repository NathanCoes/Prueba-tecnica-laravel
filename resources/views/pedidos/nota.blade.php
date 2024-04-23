<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota de Pedido</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            color: #0e2046;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .header p {
            color: #6c757d;
            font-size: 16px;
            margin-bottom: 10px;
        }

        section .card {
            width: 45%;
            display: inline-block;
            vertical-align: top;
        }

        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            /* Espacio entre las tarjetas */
        }

        .card-header {
            background-color: #f8f9fa;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .card-header h2 {
            color: #0e2046;
            font-size: 20px;
            margin: 0;
        }

        .card-body table {
            width: 100%;
            border-collapse: collapse;
        }

        .card-body table th,
        .card-body table td {
            padding: 8px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        .card-body table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .text-success {
            color: green;
            font-weight: bold;
        }

        .text-danger {
            color: red;
            font-weight: bold;
        }

        .sub {
            text-align: right !important;
            font-weight: bolder;
        }

        footer {
            font-size: 8px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Nova CRM</h1>
        <p>Atendido por: <strong>{{ $pedido['usuarios']['nombre'] }} {{ $pedido['usuarios']['apellido'] }}</strong>
            || Email: {{ $pedido['usuarios']['email'] }}</p>
        <p>Nota generada el: {{ now() }}</p>
    </div>

    <section>
        <div class="card">
            <div class="card-header">
                <h2>Cliente</h2>
            </div>
            <div class="card-body">
                <table>
                    <tr>
                        <th>Nombre cliente</th>
                        <td>{{ $pedido->clientes->nombre }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $pedido->clientes->email }}</td>
                    </tr>
                    <tr>
                        <th>RFC</th>
                        <td>{{ $pedido->clientes->rfc }}</td>
                    </tr>
                    <tr>
                        <th>Contacto</th>
                        <td>{{ $pedido->clientes->contacto }}</td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td>{{ $pedido->clientes->telefono }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Dirección de envío</h2>
            </div>
            <div class="card-body">
                <table>
                    <tr>
                        <th>Nombre</th>
                        <td>{{ $pedido->envios->nombre }}</td>
                    </tr>
                    <tr>
                        <th>Contacto</th>
                        <td>{{ $pedido->envios->contacto }}</td>
                    </tr>
                    <tr>
                        <th>Teléfono</th>
                        <td>{{ $pedido->envios->telefono }}</td>
                    </tr>
                    <tr>
                        <th>Dirección</th>
                        <td>{{ $pedido->envios->direccion }}</td>
                    </tr>
                    <tr>
                        <th>Código postal</th>
                        <td>{{ $pedido->envios->codigo_postal }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>

    <div class="card">
        <div class="card-header">
            <h2>Productos</h2>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                        <th>SKU</th>
                        <th>Unidad de medida</th>
                        <th>Precio unidad</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($productos as $item)
                        @php
                            $subtotal = $item['detalles']['precio'] * $item['cantidad'];
                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ $item['cantidad'] }}</td>
                            <td>{{ $item['detalles']['descripcion'] }}</td>
                            <td>{{ $item['detalles']['sku'] }}</td>
                            <td>{{ $item['detalles']['unidad_medida'] }}</td>
                            <td>${{ $item['detalles']['precio'] }} mxn</td>
                            <td>${{ $subtotal }} mxn</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="sub">Subtotal</td>
                        <td class="text-success">${{ $total }} mxn</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="sub">IVA 16%</td>
                        <td class="text-success">${{ $total * (16 / 100) }} mxn</td>
                    </tr>
                    <tr>
                        <td colspan="5" class="sub">Total</td>
                        <td class="text-success">${{ $total + $total * (16 / 100) }} mxn</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p> <strong>Aviso de privacidad: </strong> Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut,
            voluptatibus nisi. Hic fugit nemo adipisci cumque unde cum! Iure magnam, earum illum numquam animi itaque
            similique tempore rem recusandae eos. Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aspernatur
            hic laudantium id tempora ad, praesentium reiciendis quas numquam fuga minima sit minus accusantium iusto
            itaque illo! Atque et consequuntur doloremque. Lorem ipsum dolor sit amet consectetur adipisicing elit.
            Minus ratione non eum? Recusandae ipsam, magni repellat id odio et facilis dolores qui voluptas! Sapiente
            porro, cupiditate sed quos assumenda nisi! Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore
            sint veniam tempora reiciendis enim quasi. Distinctio, quis molestias. In officiis sapiente excepturi
            voluptate aut. Voluptatibus inventore placeat accusantium nostrum doloremque. Lorem ipsum dolor sit amet
            consectetur adipisicing elit. Iusto velit dolorem, ducimus tempore ipsa libero.
        </p>
    </footer>
</body>

</html>
