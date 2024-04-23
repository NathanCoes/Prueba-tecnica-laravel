@section('title', 'Index pedidos')
@section('page-title', 'Edición de pedidos')
@section('extraCSS')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@include('components.head')

@include('components.preloader')

@include('components.navbar')

<!-- Main Sidebar Container -->
@include('components.sidebar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pedidos.enlistar') }}">Pedidos</a></li>
    <li class="breadcrumb-item active"><a href="#">Editar</a></li>
@endsection
@include('components.header')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Cliente</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('clientes.update') }}" method="POST" id="tabla-cliente">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="row">
                                    <h4>Editando:</h4>
                                    <select class="form-control" name="cliente" id="cliente">
                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente['id'] }}"
                                                @if ($detalles_pedido->id_cliente == $cliente['id']) selected="selected" @endif>
                                                {{ $cliente->nombre }} // RFC: {{ $cliente->rfc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Nombre cliente</span>
                                </div>
                                <input type="text" class="form-control" name="nombre"
                                    value="{{ $detalles_pedido->clientes->nombre }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" name="email"
                                    value="{{ $detalles_pedido->clientes->email }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">RFC</span>
                                </div>
                                <input type="text" class="form-control" name="rfc"
                                    value="{{ $detalles_pedido->clientes->rfc }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contacto</span>
                                </div>
                                <input type="text" class="form-control" name="contacto"
                                    value="{{ $detalles_pedido->clientes->contacto }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Telefono</span>
                                </div>
                                <input type="text" class="form-control" name="telefono"
                                    value="{{ $detalles_pedido->clientes->telefono }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="row">
                                    <div class="col">
                                        <input type="hidden" name="id_cliente"
                                            value="{{ $detalles_pedido['id_cliente'] }}">
                                        <button type="submit" id="submit-data-cliente"
                                            class="btn btn-block btn-primary" disabled>Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dirección de envio</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('envios.update') }}" method="POST" id="tabla-envios">
                            @csrf
                            <div class="input-group mb-3">
                                <div class="row">
                                    <h4>Editando:</h4>
                                    <select class="form-control select2" name="direccion_envio" id="direccion_envio">
                                        @foreach ($direcciones_cliente as $direccion)
                                            <option value="{{ $direccion['id'] }}"
                                                @if ($detalles_pedido->id_direccion_envio == $direccion['id']) selected="selected" @endif>
                                                {{ $direccion->direccion }}, {{ $direccion->codigo_postal }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Nombre cliente</span>
                                </div>
                                <input type="text" class="form-control" name="nombre"
                                    value="{{ $detalles_pedido->envios->nombre }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contacto</span>
                                </div>
                                <input type="text" class="form-control" name="contacto"
                                    value="{{ $detalles_pedido->envios->contacto }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Telefono</span>
                                </div>
                                <input type="text" class="form-control" name="telefono"
                                    value="{{ $detalles_pedido->envios->telefono }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Dirección</span>
                                </div>
                                <input type="text" class="form-control" name="direccion"
                                    value="{{ $detalles_pedido->envios->direccion }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Código postal</span>
                                </div>
                                <input type="text" class="form-control" name="codigo_postal"
                                    value="{{ $detalles_pedido->envios->codigo_postal }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="row">
                                    <div class="col">
                                        <input type="hidden" name="id_direccion_envio"
                                            value="{{ $detalles_pedido->id_direccion_envio }}">
                                        <button type="submit" id="submit-data-envios"
                                            class="btn btn-block btn-primary" disabled>Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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
                                            <th>Cantidad</th>
                                            <th>Descripcion</th>
                                            <th>SKU</th>
                                            <th style="width: 40px">Unidad de medida</th>
                                            <th>Precio unidad</th>
                                            <th>Sub total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($productos as $item)
                                            @php
                                                $total += $item['detalles']['precio'] * $item['cantidad'];
                                            @endphp
                                            <tr>
                                                <td><input data-id-producto="{{ $item['detalles']['id'] }}"
                                                        type="number" min="0"
                                                        value="{{ $item['cantidad'] }}"
                                                        style="color:#fff;width:50px;padding:5px; background-color:transparent; border:1px solid #fff;border-radius:5px;">
                                                </td>
                                                <td>{{ $item['detalles']['descripcion'] }}</td>
                                                <td>{{ $item['detalles']['sku'] }}</td>
                                                <td>{{ $item['detalles']['unidad_medida'] }}</td>
                                                <td>${{ $item['detalles']['precio'] }} mxn</td>
                                                <td class="text-success">
                                                    ${{ $item['detalles']['precio'] * $item['cantidad'] }} mxn</td>
                                                <td> <button class="btn btn-danger"
                                                        data-id-producto="{{ $item['detalles']['id'] }}"><i
                                                            class="fas fa-trash"></i></button></td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <th>Total</th>
                                            <th class="text-success">${{ $total }} mxn</th>
                                            <td><button class="btn btn-block btn-info btn-getInfoPedido"
                                                    data-toggle="modal" data-target="#exampleModal"
                                                    data-toggle="tooltip" data-placement="right"
                                                    title="Agregar producto"><i class="fas fa-plus"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
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
                    <form action="{{ route('pedidos.add.producto') }}" method="post">
                        @csrf
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
                                        <input type="number" name="cantidad" min="1" value="1"
                                            style="color:#fff;width:50px;padding:5px; background-color:transparent; border:1px solid #fff;border-radius:5px;">
                                    </td>
                                    <td>
                                        <select name="id_producto" id="producto">
                                            <option selected disabled>Seleciona un producto, verifica la cantidad
                                                agregada y listo...</option>
                                            @foreach ($allProductos as $producto)
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
                            <button type="button" class="btn btn-secondary cls" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary"
                                id="producto-seleccionado">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@section('extraJS')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var id_cliente = false,
            id_direccion_envio = false;

        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        });

        $("#direccion_envio").select2();
        $("#cliente").select2();
        $("#producto").select2();

        $("input[data-id-producto]").change(function() {

            $id_producto = $(this).data('id-producto');
            $cantidad = $(this).val();

            toastr.clear();
            toastr.info("Cambio en un producto detectado, esperé por favor.");

            let timeout;

            clearTimeout(timeout);

            timeout = setTimeout(() => {
                toastr.clear();
                if ($cantidad == 0) {
                    toastr.warning("Detectamos 0 en Cantidad sobre un producto, por ende lo borraremos.");
                    borrarProducto($id_producto);
                } else {
                    $.ajax({
                        type: "POST",
                        url: "/pedidos/update",
                        data: {
                            'id_producto': $id_producto,
                            'cantidad': $cantidad,
                            '_token': csrfToken
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.success);
                                toastr.warning('Recargando...');
                                setTimeout(() => {
                                    location.reload();
                                }, 3500);
                            } else {
                                toastr.alert(response.error);
                            }
                        }
                    });
                }
            }, 3000);
        });

        $("button[data-id-producto]").click(function(e) {
            e.preventDefault();
            $id_producto = $(this).data('id-producto');
            borrarProducto($id_producto);
        });

        $("#tabla-cliente input").change(function() {
            $("#submit-data-cliente").removeAttr("disabled");
        });
        $("#tabla-envios input").change(function() {
            $("#submit-data-envios").removeAttr("disabled");
        });

        $("#cliente").change(function() {
            $id_cliente = $(this).val();
            $.ajax({
                type: "POST",
                url: "/pedidos/update",
                data: {
                    'id_cliente': $id_cliente,
                    '_token': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        toastr.warning('Recargando...');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        toastr.alert(response.error);
                    }
                }
            });
        });

        $("#direccion_envio").change(function() {
            $id_direccion_envio = $(this).val();
            $.ajax({
                type: "POST",
                url: "/pedidos/update",
                data: {
                    'id_direccion_envio': $id_direccion_envio,
                    '_token': csrfToken
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.success);
                        toastr.warning('Recargando...');
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        toastr.alert(response.error);
                    }
                }
            });
        });

        $("#producto").change(function() {
            $("#producto-seleccionado").removeAttr("disabled");
        });
        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if (session('error'))
            toastr.warning('{{ session('error') }}');
        @endif

        function borrarProducto(id_producto) {
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
                    $.ajax({
                        type: "POST",
                        url: "/pedidos/producto/delete",
                        data: {
                            'id_producto': id_producto,
                            '_token': csrfToken
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success(response.success);
                                toastr.warning('Recargando...');
                                setTimeout(() => {
                                    location.reload();
                                }, 3500);
                            } else {
                                toastr.error(response.error);
                            }
                        }
                    });
                }
            });

        }
    </script>

@endsection
@include('components.footer')
