<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Casos Cerrados Reclamos AGBC</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item active">Registros</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left d-flex align-items-center">
                                <input type="text" wire:model="searchTerm" placeholder="Buscar..."
                                    class="form-control" style="margin-right: 10px;">
                                <button type="button" class="btn btn-primary" wire:click="$refresh">Buscar</button>
                            </div>
                            <div class="float-right d-flex align-items-center">
                                <input type="date" wire:model="selectedDate" class="form-control">
                                <button type="button" class="btn btn-primary ml-2" wire:click="exportPdf">Exportar a
                                    PDF</button>
                            </div>
                        </div>
                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        {{-- <th><input type="checkbox" wire:model="selectAll"></th> --}}
                                        <th>Codificacion</th>
                                        <th>Remitente</th>
                                        <th>Teléfono Remitente</th>
                                        <th>Email Remitente</th>
                                        <th>Destino</th>
                                        <th>Código</th>
                                        <th>Fecha de Envío</th>
                                        <th>Contenido</th>
                                        <th>Valor</th>
                                        @hasrole('SuperAdmin|Administrador')
                                            <th>Calificacion</th>
                                            <th>Ciudad</th>
                                        @endhasrole
                                        <th>Estado</th>
                                        <th>Actualizado</th>
                                        {{-- <th>Acciones</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($claims as $claim)
                                        <tr>
                                            {{-- <td><input type="checkbox" wire:model="selectedClaims"
                                                    value="{{ $claim->id }}"></td> --}}
                                            <td>{{ $claim->correlativo }}</td>
                                            <td>{{ $claim->remitente }}</td>
                                            <td>{{ $claim->telf_remitente }}</td>
                                            <td>{{ $claim->origen }}</td>
                                            <td>{{ $claim->destino }}</td>
                                            <td>{{ $claim->codigo }}</td>
                                            <td>{{ $claim->fecha_envio }}</td>
                                            <td>{{ $claim->contenido }}</td>
                                            <td>{{ $claim->valor }}</td>
                                            @hasrole('SuperAdmin|Administrador')
                                                <td>{{ $claim->feedback ?? 0 }}</td>
                                                <td>{{ $claim->ciudad }}</td>
                                            @endhasrole
                                            <td>{{ $claim->estado }}</td>
                                            <td>{{ $claim->updated_at }}</td>
                                            <td>
                                                <div class="d-flex" role="group" aria-label="Acciones">
                                                    <button type="button" class="btn btn-info mr-2"
                                                        wire:click="mostrarReclamo({{ $claim->id }})"
                                                        target="_blank">
                                                        Ver Reclamo
                                                    </button>
                                                    @hasrole('SuperAdmin|Administrador')
                                                        <button type="button" class="btn btn-success"
                                                            wire:click="darDeAlta({{ $claim->id }})">
                                                            Abrir Caso
                                                        </button>
                                                    @endhasrole
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <!-- Enlaces de paginación -->
                            {{ $claims->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
