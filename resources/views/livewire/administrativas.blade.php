<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Seguimiento de Quejas Administrativas AGBC</h1>
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
                                {{-- <button type="button" class="btn btn-warning ml-2"
                                    wire:click="cambiarEstadoReclamos">Cambiar a Reclamos</button> --}}
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
                                        <th>Cliente</th>
                                        <th>Teléfono</th>
                                        <th>Carnet de Identidad</th>
                                        <th>Email</th>
                                        <th>Funcionario AGBC</th>
                                        <th>Tipo</th>
                                        <th>Estado</th>
                                        <th>Creado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($complaints as $complaint)
                                        <tr>
                                            {{-- <td><input type="checkbox" wire:model="selectedcomplaints"
                                                    value="{{ $complaint->id }}"></td> --}}
                                            <td>{{ $complaint->cliente }}</td>
                                            <td>{{ $complaint->telf }}</td>
                                            <td>{{ $complaint->ci }}</td>
                                            <td>{{ $complaint->email }}</td>
                                            <td>{{ $complaint->funcionario }}</td>
                                            <td>{{ $complaint->tipo }}</td>
                                            <td>{{ $complaint->estado }}</td>
                                            <td>{{ $complaint->created_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info"
                                                    wire:click="mostrarReclamo({{ $complaint->id }})" target="_blank">
                                                    Ver Reclamo
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <!-- Enlaces de paginación -->
                            {{ $complaints->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
