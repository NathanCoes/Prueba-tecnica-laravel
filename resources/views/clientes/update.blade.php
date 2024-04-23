@section('title', 'Clientes')
@section('page-title', 'Actualizar ')
@section('extraCSS')
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
@endsection

@include('components.head')

@include('components.preloader')

@include('components.navbar')

<!-- Main Sidebar Container -->
@include('components.sidebar')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('clientes.index')}}">Clientes</a></li>
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
                        <form action="{{ route('clientes.update') }}" method="POST"$cliente>
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Nombre cliente</span>
                                </div>
                                <input type="text" class="form-control" name="nombre"
                                    value="{{ $cliente->nombre }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" name="email"
                                    value="{{ $cliente->email }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">RFC</span>
                                </div>
                                <input type="text" class="form-control" name="rfc"
                                    value="{{ $cliente->rfc }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Contacto</span>
                                </div>
                                <input type="text" class="form-control" name="contacto"
                                    value="{{ $cliente->contacto }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Telefono</span>
                                </div>
                                <input type="text" class="form-control" name="telefono"
                                    value="{{ $cliente->telefono }}">
                            </div>
                            <div class="input-group mb-3">
                                <div class="row">
                                    <div class="col">
                                        <input type="hidden" name="id_cliente"
                                            value="{{ $cliente['id'] }}">
                                        <button type="submit"
                                            class="btn btn-block btn-primary">Guardar</button>
                                        @if ($cliente['id'] != 1)
                                        <a style="color: #fff;" class="btn btn-block btn-danger" href="{{route("clientes.delete")}}/{{$cliente->id}}">Borrar</a>
                                        @endif
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
    @if (session('success'))
        toastr.success('{{ session('success') }}');
    @endif

    @if (session('error'))
        toastr.warning('{{ session('error') }}');
    @endif
@endsection
@include('components.footer')
