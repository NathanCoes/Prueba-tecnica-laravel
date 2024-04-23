@section('title', 'Crear producto')
@section('page-title', 'Nuevo producto')
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
    <li class="breadcrumb-item"><a href="{{route('productos.index')}}">Productos</a></li>
    <li class="breadcrumb-item active"><a href="#">Crear</a></li>
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
                        <form action="{{ route('productos.save') }}" method="POST"$cliente>
                            @csrf
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">SKU</span>
                                </div>
                                <input type="text" class="form-control" name="sku">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Descripcion</span>
                                </div>
                                <input type="text" class="form-control" name="descripcion">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Unidad de medida</span>
                                </div>
                                <input type="text" class="form-control" name="unidad_medida">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Precio</span>
                                </div>
                                <input type="text" class="form-control" name="precio">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Unidades disponibles</span>
                                </div>
                                <input type="text" class="form-control" name="unidades_disponibles">
                            </div>
                            <div class="input-group mb-3">
                                <div class="row">
                                    <div class="col">
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
    @if (session('success'))
        toastr.success('{{ session('success') }}');
    @endif

    @if (session('error'))
        toastr.warning('{{ session('error') }}');
    @endif
@endsection
@include('components.footer')
