<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lista de Registros</h1>
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
                            <div class="float-right d-flex align-items-center">
                                <input type="date" wire:model="selectedDate" class="form-control">
                                <button type="button" class="btn btn-primary ml-2" wire:click="exportPdf">Exportar a
                                    PDF</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="recordsTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Código</th>
                                        <th>Destinatario</th>
                                        <th>Último Evento</th>
                                        <th>Teléfono</th>
                                        <th>Ciudad</th>
                                        <th>Ventanilla</th>
                                        <th>Último Estado</th>
                                        <th>Descripción</th>
                                        <th>Fecha del Último Evento</th>
                                        <th>Estado</th>
                                        <th>Feedback</th>
                                        <th>Creado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $record)
                                        <tr>
                                            <td>{{ $record->id }}</td>
                                            <td>{{ $record->codigo }}</td>
                                            <td>{{ $record->destinatario }}</td>
                                            <td>{{ $record->last_event }}</td>
                                            <td>{{ $record->telefono }}</td>
                                            <td>{{ $record->ciudad }}</td>
                                            <td>{{ $record->ventanilla }}</td>
                                            <td>{{ $record->last_status }}</td>
                                            <td>{{ $record->last_description }}</td>
                                            <td>{{ $record->last_date }}</td>
                                            <td>{{ $record->estado }}</td>
                                            <td>{{ $record->feedback }}</td>
                                            <td>{{ $record->create_at }}</td>
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
