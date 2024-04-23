@section('title', 'Index clientes')
@section('page-title', 'Lista de clientes')
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
    <li class="breadcrumb-item active"><a href="#">Clientes</a></li>
@endsection
@include('components.header')
<section class="content">
    <div class="container-fluid">
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>RFC</th>
                        <th>Email</th>
                        <th>Contacto</th>
                        <th>Telefono</th>
                        <th>Se unio el</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->rfc }}</td>
                            <td>{{ $cliente->email }}</td>
                            <td>{{ $cliente->contacto }}</td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->created_at }}</td>
                            <td>
                                <a class="btn btn-block btn-info btn-sm"
                                    href="{{ route('clientes.show') }}/{{ $cliente->id }}">Ver detalles</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
</section>

@section('extraJS')
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
        });
        @if (session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        @if (session('error'))
            toastr.warning('{{ session('error') }}');
        @endif
    </script>
@endsection
@include('components.footer')
