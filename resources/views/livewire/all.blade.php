<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Registros Nuevos de Reclamos</h1>
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
                                        <th>Correlativo</th>
                                        <th>Remitente</th>
                                        <th>Teléfono</th>
                                        <th>Estado</th>
                                        <th>Fecha Creacion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($records as $record)
                                        <tr>
                                            <td>{{ $record->correlativo ?? 'N/A' }}</td>
                                            <td>{{ $record->remitente ?? 'N/A' }}</td>
                                            <td>{{ $record->telf ?? 'N/A' }}</td>
                                            <td>{{ $record->estado ?? 'N/A' }}</td>
                                            <td>{{ $record->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $records->onEachSide(1)->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
