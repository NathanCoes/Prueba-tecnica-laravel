@section('title', 'Crear pedido')
@section('page-title', 'Crear un pedido')
@section('extraCSS')

    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection
@include('components.head')

@include('components.preloader')

@include('components.navbar')

<!-- Main Sidebar Container -->
@include('components.sidebar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="#">Pedidos</a></li>
    <li class="breadcrumb-item active"><a href="#">Crear</a></li>
@endsection
@include('components.header')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Facil pedido</h3>
                    </div>
                    <form action="{{route('pedidos.create')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <input type="hidden" id="input-id_productos" name="id_productos">
                            <input type="hidden" id="input-monto" name="monto">
                            <div class="form-group">
                                <label for="cliente">Cliente</label>
                                <select name="cliente" id="cliente" style="width: 100%">>
                                    <option selected disabled>Selecciona un cliente</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }} || RFC:
                                            {{ $cliente->rfc }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="envio">Direccion de envio</label>
                                <select name="envio" id="envio" style="width: 100%">>
                                    <option selected disabled>Selecccione un cliente...</option>
                                </select>
                            </div>
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Productos</h3>
                                </div>
                                <div class="card-body">
                                    <div class="card">
                                        <div class="card-body p-0">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 40px">Cantidad</th>
                                                        <th>Descripcion</th>
                                                        <th>SKU</th>
                                                        <th style="width: 120px">Unidad de medida</th>
                                                        <th style="width: 60px">Precio unidad</th>
                                                        <th style="width: 120px">Sub total</th>
                                                        <th style="width: 40px"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="content-productos">

                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="5" style="text-align: right">Subtotal</th>
                                                        <th class="text-success">$<span id="subtotal">0</span> mxn</th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="5" style="text-align: right">IVA 16%</th>
                                                        <th class="text-success">$<span id="iva">0</span> mxn</th>
                                                        <td colspan="2"></td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="5" style="text-align: right">Total</th>
                                                        <th class="text-success">$<span id="total">0</span> mxn</th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="6"></th>
                                                        <th style="width: 40px">
                                                            <button type="button"
                                                                class="btn btn-block btn-info btn-getInfoPedido"
                                                                data-toggle="modal" data-target="#exampleModal"
                                                                data-placement="right" title="Agregar producto"><i
                                                                    class="fas fa-plus"></i></button>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="savePedido" disabled>Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Producto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="number" name="cantidad" id="cantidad" min="1" value="1"
                                        style="color:#fff;width:50px;padding:5px; background-color:transparent; border:1px solid #fff;border-radius:5px;">
                                </td>
                                <td>
                                    <select name="id_producto" id="producto">
                                        <option selected disabled>Seleciona un producto, verifica la cantidad
                                            agregada y listo...</option>
                                        @foreach ($productos as $producto)
                                            <option value="{{ $producto['id'] }}">
                                                SKU: {{ $producto->sku }} // Descripcion:
                                                {{ $producto->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button class="btn btn-secondary cls" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" id="producto-seleccionado">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('extraJS')
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $("#cliente").select2();
        $("#envio").select2();
        $("#producto").select2();

        var productos_agregados = [];
        var total = 0;
        var id_producto;
        var productos = {
            @foreach ($productos as $producto)
                '{{ $producto['id'] }}': {
                    'sku': '{{ $producto['sku'] }}',
                    'descripcion': '{{ $producto['descripcion'] }}',
                    'unidad_medida': '{{ $producto['unidad_medida'] }}',
                    'precio': '{{ $producto['precio'] }}'
                },
            @endforeach
        }

        $("#cliente").change(function() {
            $id_cliente = $(this).val();
            $("#envio").select2({
                ajax: {
                    url: '{{ route('envios.get', ['id' => '_id_cliente_']) }}'.replace(
                        '_id_cliente_', $id_cliente),
                    dataType: 'json',
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                allowClear: true
            });
            readyToSend();
        });

        $("#envio").change(function(){
            readyToSend();
        });

        $("#producto-seleccionado").click(function(e) {
            e.preventDefault();
            $cantidad = $("#cantidad").val();
            id_producto = $("#producto").val();

            if (id_producto != null) {

                $i = 0;
                $finded = false;
                productos_agregados.forEach(element => {
                    if (productos_agregados[$i]['id_producto'] == id_producto) {
                        $finded = true;
                        console.log(id_producto);
                        console.log(productos_agregados[$i]['cantidad']);
                        productos_agregados[$i]['cantidad'] = parseInt(productos_agregados[$i]['cantidad'])+parseInt($cantidad);
                        console.log(productos_agregados[$i]['cantidad']);
                        $(`strong[data-id-producto="${id_producto}"]`).html("$" + productos_agregados[$i]['cantidad']*productos[id_producto]['precio'] + " mxn");
                        $(`input[data-id-producto="${id_producto}"]`).attr("value", parseInt(productos_agregados[$i]['cantidad']));
                    }
                    $i++;
                });

                if ($finded == false) {
                    productos_agregados.push({
                        'id_producto': id_producto,
                        'cantidad': $cantidad
                    });
                    $html = $("#content-productos").html();
                    $html += `
                        <tr data-id-producto='${id_producto}'>
                            <td>
                                <input
                                    type="number"
                                    min="1"
                                    data-id-producto="${id_producto}"
                                    value="${$cantidad}"
                                    style='width: 40px; background-color:transparent; border: 1px solid #fff; color: #fff; border-radius: 5px;'>
                            </td>
                            <td>${productos[id_producto]['descripcion']}</td>
                            <td>${productos[id_producto]['sku']}</td>
                            <td>${productos[id_producto]['unidad_medida']}</td>
                            <td class='text-success'><strong>$${productos[id_producto]['precio']} mxn</strong></td>
                            <td class='text-success'><strong data-id-producto="${id_producto}">$${$cantidad*productos[id_producto]['precio']} mxn</strong></td>
                            <td>
                                <button type="button" class="btn btn-danger" data-id-producto="${id_producto}"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `;

                    $("#content-productos").html($html);
                }


                total += $cantidad * productos[id_producto]['precio'];
                $iva = total * (16 / 100);
                $("#subtotal").html(total);
                $("#iva").html($iva.toFixed(2));
                $("#total").html((total + $iva).toFixed(2));

                $("#input-monto").val(total);
                $("#input-id_productos").val(JSON.stringify(productos_agregados));
                id_producto = null;
                controladorProductos();
                readyToSend();
            }
        });

        function controladorProductos() {
            $("button[data-id-producto]").click(function() {
                id_producto = $(this).data('id-producto');
                Swal.fire({
                    title: "No hay marcha atrás",
                    text: "Deseas borrar esté articulo?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $(`tr[data-id-producto='${id_producto}']`).remove();
                        $nueva_lista_productos = [];
                        total = 0;
                        productos_agregados.forEach(element => {
                            if (element['id_producto'] != id_producto) {
                                $nueva_lista_productos.push(element);
                                total += productos[element['id_producto']]['precio'] * element[
                                    'cantidad'];
                            }
                        });

                        productos_agregados = $nueva_lista_productos;
                        $("#input-id_productos").val(JSON.stringify(productos_agregados));
                        $iva = total * (16 / 100);
                        $("#subtotal").html(total);
                        $("#iva").html($iva.toFixed(2));
                        $("#total").html((total + $iva).toFixed(2));
                    }
                });
                readyToSend();
            });

            $("input[data-id-producto]").change(function() {
                $cantidad = $(this).val();
                id_producto = $(this).data('id-producto');
                total = 0;
                $temp = 0;
                productos_agregados.forEach(element => {
                    if (element['id_producto'] == id_producto) {
                        element['cantidad'] = $cantidad;
                        $temp = productos[element['id_producto']]['precio'] * element[
                            'cantidad'];
                    }
                    total += productos[element['id_producto']]['precio'] * element[
                        'cantidad'];
                });

                $iva = total * (16 / 100);
                $(`strong[data-id-producto="${id_producto}"]`).html("$" + $temp + " mxn");
                $("#input-id_productos").val(JSON.stringify(productos_agregados));
                $("#subtotal").html(total);
                $("#iva").html($iva.toFixed(2));
                $("#total").html((total + $iva).toFixed(2));
            });
        }

        function readyToSend(){
            $client= false;
            $dir = false;

            if ($("#cliente").val() != 0 && $("#cliente").val() != null){
                $client = true;
            }
            if($("#envio").val() != 0 && $("#envio").val() != null){
                $dir = true;
            }
            if ($dir == true && $client == true && productos_agregados.length > 0){
                $("#savePedido").removeAttr("disabled");
            }else{
                $("#savePedido").attr("disabled");
            }
        }

        @if (session('success'))
            Swal.fire({
                icon: "success",
                title: "Listo!",
                text: "{{session('success')}}",
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{session('error')}}",
            });
        @endif
    </script>
@endsection
@include('components.footer')
