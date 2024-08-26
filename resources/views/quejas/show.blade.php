@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Estadísticas de Paquetería Postal
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Detalle del Queja {{ $complaint->correlativo }}</h1>

        <div class="row">
            <!-- Primera Columna -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Detalles del Cliente</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Cliente:</strong> {{ $complaint->cliente }}</p>
                        <p><strong>Telefono:</strong> {{ $complaint->telf }}</p>
                        <p><strong>Carnet de Identidad:</strong> {{ $complaint->ci }}</p>
                        <p><strong>Correo Electronico:</strong> {{ $complaint->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <!-- Tercera Columna -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h4>Detalles de la Queja</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Funcionario:</strong> {{ $complaint->funcionario    }}</p>
                        <p><strong>Detalles de la Queja:</strong> {{ $complaint->queja }}</p>
                        <p><strong>Tipo de Queja:</strong> {{ $complaint->tipo }}</p>
                        <p><strong>Fecha Creado:</strong> {{ $complaint->created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row mt-2">
            <div class="col-md-12 text-right">
                <a href="{{ route('seguimiento.create', ['complaint' => $complaint->id]) }}" class="btn btn-success">
                    Crear Seguimiento
                </a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h4>Seguimientos</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($follows as $follow)
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Ficha:</strong> {{ $follow->ficha }}</p>
                                        <p><strong>Seguimiento:</strong> {{ $follow->seguimiento }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Documentos:</strong> {{ $follow->docs }}</p>
                                        <p><strong>Acciones:</strong> {{ $follow->acciones }}</p>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    @include('footer')
@stop
