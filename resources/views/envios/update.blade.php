@section('title', 'Envios update')
@section('page-title', 'Actualizar envios')
@section('extraCSS')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
@endsection

@include('components.head')

@include('components.preloader')

@include('components.navbar')

<!-- Main Sidebar Container -->
@include('components.sidebar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('envios.index')}}">Envios</a></li>
    <li class="breadcrumb-item active"><a href="#">Ver - actualizar</a></li>
@endsection
@include('components.header')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Cliente</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('envios.update') }}" method="POST">
                            @csrf

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Nombre</span>
                                </div>
                                <input type="text" class="form-control" name="nombre"
                                    value="{{ $envio->nombre }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Direccion</span>
                                </div>
                                <input type="text" class="form-control" name="direccion"
                                    value="{{ $envio->direccion }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Codigo postal</span>
                                </div>
                                <input type="text" class="form-control" name="codigo_postal"
                                    value="{{ $envio->codigo_postal }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contacto</span>
                                </div>
                                <input type="text" class="form-control" name="contacto"
                                    value="{{ $envio->contacto }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Telefono</span>
                                </div>
                                <input type="text" class="form-control" name="telefono"
                                    value="{{ $envio->telefono }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="row">
                                    <div class="col">
                                        <input type="hidden" name="id_direccion_envio"
                                            value="{{ $envio->id }}">
                                        <button type="submit"
                                            class="btn btn-block btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@section("extraJS")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>

    <script>
        $("#cliente").select2();

        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if (session('error'))
            toastr.warning('{{ session('error') }}');
        @endif
    </script>
@endsection
@include('components.footer')
