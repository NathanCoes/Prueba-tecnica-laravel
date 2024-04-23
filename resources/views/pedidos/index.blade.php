@section('title', 'Index pedidos')
@section('page-title', 'Pedidos')
@section('extraCSS')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .rel-pedidos {
            display: none;
        }
    </style>
@endsection

@include('components.head')

@include('components.preloader')

@include('components.navbar')

<!-- Main Sidebar Container -->
@include('components.sidebar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="#">Pedidos</a></li>
    <li class="breadcrumb-item active"><a href="#">Index</a></li>
@endsection
@include('components.header')

<section class="content">
    <div class="container-fluid">
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Monto</th>
                        <th>Creado por</th>
                        <th>Fecha pedido</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->clientes->nombre }}</td>
                            <td class="text-success text-bold">${{ $pedido->monto }} mxn</td>
                            <td>{{ $pedido->usuarios->nombre }} {{ $pedido->usuarios->apellido }}</td>
                            <td>{{ $pedido->created_at }}</td>
                            <td>
                                <button type="button" class="btn btn-block btn-info btn-sm btn-getInfoPedido"
                                    data-toggle="modal" data-target="#exampleModal"
                                    data-pedido-id="{{ $pedido->id }}">
                                    Ver detalles</button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="exampleModal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles del pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row rel-pedidos">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Cliente</h3>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-sm" id="infoCliente">

                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dirección de envio</h3>
                        </div>

                        <div class="card-body p-0">
                            <table class="table table-sm" id="infoEnvio">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row rel-pedidos">
                <div class="col-sm-12">
                    <div class="card-header">
                        <h3 class="card-title">Productos
                        </h3>
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-sm" id="infoProducto">

                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-body" id="info-pedido">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-info" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cls" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" id="descargarXML">
                    <i class="fas fa-file-download"></i> Descargar zip XML
                </button>
                <button type="button" class="btn btn-info" id="descargarNota"><i class="fas fa-file-download"></i>
                    Descargar nota</button>
                <button type="button" class="btn btn-primary" id="pedidoEditar"><i class="fas fa-edit"></i>
                    Editar</button>
                <button type="button" class="btn btn-danger" id="pedidoBorrar"><i class="fas fa-trash"></i> Borrar
                    pedido</button>
            </div>
        </div>
    </div>
</div>
@section('extraJS')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        });
    </script>
    <script>
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var pedido_id = undefined;
        var productos = undefined;
        $(".close , .cls").click(function() {
            $("#info-pedido").css("display", "block");
            $(".rel-pedidos").css("display", "none");
        });
        $(".btn-getInfoPedido").click(function(e) {
            e.preventDefault();
            pedido_id = $(this).data('pedido-id')
            $.ajax({
                type: "POST",
                url: "/pedidos",
                data: {
                    'pedido_id': pedido_id,
                    '_token': csrfToken
                },
                success: function(response) {
                    $("#info-pedido").css("display", "none");
                    $(".rel-pedidos").css("display", "flex");
                    console.log(response);
                    productos = response.productos;

                    $infoCliente = `
                        <tr>
                            <th>Nombre cliente</th>
                            <td> ` + response.detalles_pedido.clientes.nombre + `</td>
                        </tr>
                        <tr>
                            <th>Email cliente</th>
                            <td> ` + response.detalles_pedido.clientes.email + `</td>
                        </tr>
                        <tr>
                            <th>RFC</th>
                            <td> ` + response.detalles_pedido.clientes.rfc + `</td>
                        </tr>
                        <tr>
                            <th>Contacto</th>
                            <td> ` + response.detalles_pedido.clientes.contacto + `</td>
                        </tr>
                        <tr>
                            <th>Telefono</th>
                            <td> ` + response.detalles_pedido.clientes.telefono + `</td>
                        </tr>
                        <tr>
                            <th>Cliente desde</th>
                            <td> ` + response.detalles_pedido.clientes.created_at + `</td>
                        </tr>
                    `;
                    $("#infoCliente").html($infoCliente);

                    $infoEnvio = `
                        <tr>
                            <th>Cliente</th>
                            <td>` + response.detalles_pedido.envios.nombre + `</td>
                        </tr>
                        <tr>
                            <th>Contacto</th>
                            <td>` + response.detalles_pedido.envios.contacto + `</td>
                        </tr>
                        <tr>
                            <th>Telefono</th>
                            <td>` + response.detalles_pedido.envios.telefono + `</td>
                        </tr>
                        <tr>
                            <th>Direccion</th>
                            <td>` + response.detalles_pedido.envios.direccion + `</td>
                        </tr>
                        <tr>
                            <th>Codigo postal</th>
                            <td>` + response.detalles_pedido.envios.codigo_postal + `</td>
                        </tr>
                        <tr>
                            <th>Registrado el</th>
                            <td>` + response.detalles_pedido.envios.created_at + `</td>
                        </tr>
                    `;
                    $("#infoEnvio").html($infoEnvio);
                    $infoProducto =
                        `<thead><th>Cantidad</th><th>Descripcion</th><th>SKU</th><th>Unidad medida</th><th>Precio Unidad</th><th>Sub total</th></thead>`;
                    $total = 0;
                    for (let key in response.productos) {
                        $infoProducto += `
                            <tr>
                                <td>` + response.productos[key].cantidad + `</td>
                                <td>` + response.productos[key].detalles.descripcion + `</td>
                                <td>` + response.productos[key].detalles.sku + `</td>
                                <td>` + response.productos[key].detalles.unidad_medida + `</td>
                                <td>$` + response.productos[key].detalles.precio + ` mxn</td>
                                <td class='text-success'>$` + response.productos[key].detalles.precio * response
                            .productos[key].cantidad + ` mxn</td>
                            </tr>
                        `;
                        $total += response.productos[key].detalles.precio * response.productos[key]
                            .cantidad;
                    }
                    $infoProducto += `
                        <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                            <th class='text-success'>$` + $total + ` mxn</th>
                        </tfoot>
                    `;
                    $("#infoProducto").html($infoProducto);
                }
            });
        });

        $("#pedidoEditar").click(function() {
            Swal.fire({
                title: "Estas seguro?",
                text: "Deseas editar esté pedido?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Vamos!"
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "/pedidos/edit/" + pedido_id;
                }
            });
        });

        $("#pedidoBorrar").click(function(e) {
            e.preventDefault();
            Swal.fire({
                title: "Deseas borrarlo?",
                text: "No hay marcha atrás",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Borrar"
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = "/pedidos/delete/" + pedido_id;
                }
            });
        });

        $("#descargarNota").click(function() {
            location.href = "/pedidos/nota/download/" + pedido_id;
        });

        $("#descargarXML").click(function(){
            console.log("click");
            location.href = "{{route('productos.xml')}}/"+pedido_id
        });

        @if (session('success'))
            Swal.fire({
                icon: "success",
                title: "Listo!",
                text: "{{ session('success') }}",
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ session('error') }}",
            });
        @endif
    </script>

@endsection
@include('components.footer')
