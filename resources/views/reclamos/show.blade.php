@extends('adminlte::page')

@section('title', 'SIRECO')

@section('template_title')
    Estadísticas de Paquetería Postal
@endsection

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Detalle del Reclamo correlativo {{ $claim->correlativo }}</h1>

        <div class="row">
            <!-- Primera Columna -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Detalles del Paquete</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Código:</strong> {{ $claim->codigo }}</p>
                        <p><strong>Fecha de Envío:</strong> {{ $claim->fecha_envio }}</p>
                        <p><strong>Contenido:</strong> {{ $claim->contenido }}</p>
                        <p><strong>Valor:</strong> {{ $claim->valor }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h4>Otros Detalles</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Creado:</strong> {{ $claim->created_at }}</p>
                        <p><strong>Dirección Destinatario:</strong> {{ $claim->direccion_d }}</p>
                        <p><strong>Código Postal:</strong> {{ $claim->codigo_postal }}</p>
                        <p></p><br>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <!-- Tercera Columna -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h4>Detalles del Remitente</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Remitente:</strong> {{ $claim->remitente }}</p>
                        <p><strong>Teléfono Remitente:</strong> {{ $claim->telf_remitente }}</p>
                        <p><strong>Email Remitente:</strong> {{ $claim->email_r }}</p>
                        <p><strong>Origen:</strong> {{ $claim->origen }}</p>
                    </div>
                </div>
            </div>

            <!-- Segunda Columna -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h4>Detalles del Destinatario</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Destinatario:</strong> {{ $claim->destinatario }}</p>
                        <p><strong>Teléfono Destinatario:</strong> {{ $claim->telf_destinatario }}</p>
                        <p><strong>Email Destinatario:</strong> {{ $claim->email_d }}</p>
                        <p><strong>Destino:</strong> {{ $claim->destino }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12 text-right">
                @hasrole('SuperAdmin|Administrador|Reclamos')
                    @if ($claim->estado == 'RECLAMOS')
                        <a href="{{ route('seguimiento.create', ['claim' => $claim->id]) }}" class="btn btn-success">
                            Crear Seguimiento
                        </a>
                    @endif
                @endhasrole
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
                                        <p><strong>Acciones:</strong> {{ $follow->acciones }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        
                                        @php
                                            // Filtrar los documentos asociados solo a este seguimiento (follow_id)
                                            $documents = \App\Models\Data::where('follow_id', $follow->id)->get();
                                        @endphp

                                        @if ($documents->count() > 0)
                                            <p><strong>Documentos:</strong></p>
                                            <ul>
                                                @foreach ($documents as $document)
                                                    <li>
                                                        <!-- Mostrar el nombre del archivo como enlace -->
                                                        <a
                                                            href="{{ route('documents.download', basename($document->docs)) }}">
                                                            {{ basename($document->docs) }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p><strong>Documentos:</strong> No hay documentos asociados a este seguimiento.
                                            </p>
                                        @endif

                                        
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@stop
