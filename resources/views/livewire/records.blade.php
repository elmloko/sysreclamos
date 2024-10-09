<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Registros de Informaciones</h1>
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
                        <div class="card-body">
                            <table id="recordsTable" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Codificacion</th>
                                        <th>Código</th>
                                        <th>Destinatario</th>
                                        <th>Último Evento</th>
                                        <th>Teléfono</th>
                                        <th>Ventanilla</th>
                                        <th>Último Estado</th>
                                        <th>Descripción</th>
                                        <th>Fecha del Último Evento</th>
                                        @hasrole('SuperAdmin|Administrador')
                                            <th>Calificacion</th>
                                            <th>Ciudad</th>
                                        @endhasrole
                                        <th>Estado</th>
                                        <th>Creado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $record)
                                        <tr>
                                            <td>{{ $record->id }}</td>
                                            <td>{{ $record->correlativo }}</td>
                                            <td>{{ $record->codigo }}</td>
                                            <td>{{ $record->destinatario }}</td>
                                            <td>{{ $record->last_event }}</td>
                                            <td>{{ $record->telefono }}</td>
                                            <td>{{ $record->ventanilla }}</td>
                                            <td>{{ $record->last_status }}</td>
                                            <td>{{ $record->last_description }}</td>
                                            <td>{{ $record->last_date }}</td>
                                            @hasrole('SuperAdmin|Administrador')
                                                <td>{{ $record->feedback ?? 0 }}</td>
                                                <td>{{ $record->ciudad }}</td>
                                            @endhasrole
                                            <td>
                                                @if($record->estado == 'SAC')
                                                    AUTOMATICO
                                                @elseif($record->estado == 'SAC MANUAL')
                                                    MANUAL
                                                @elseif($record->estado == 'LLAMADA')
                                                    LLAMADA
                                                @else
                                                    {{ $record->estado }}
                                                @endif
                                            </td>                                            
                                            <td>{{ $record->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <!-- Enlaces de paginación -->
                            {{ $records->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
