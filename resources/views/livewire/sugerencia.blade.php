<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Seguimiento de Quejas Operativa AGBC</h1>
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
                                        <th>Cliente</th>
                                        <th>Direccion</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Pais</th>
                                        <th>Codigo Postal</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Creado</th>
                                        {{-- <th>Acciones</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suggestions as $suggestion)
                                        <tr>
                                            {{-- <td><input type="checkbox" wire:model="selectedsuggestions"
                                                    value="{{ $suggestion->id }}"></td> --}}
                                            <td>{{ $suggestion->correlativo }}</td>
                                            <td>{{ $suggestion->fullName }}</td>
                                            <td>{{ $suggestion->address }}</td>
                                            <td>{{ $suggestion->email }}</td>
                                            <td>{{ $suggestion->phone }}</td>
                                            <td>{{ $suggestion->codepostal }}</td>
                                            <td>{{ $suggestion->country }}</td>
                                            <td>{{ $suggestion->description }}</td>
                                            <td>{{ $suggestion->estado }}</td>
                                            <td>{{ $suggestion->created_at }}</td>
                                            {{-- <td>
                                                <button type="button" class="btn btn-info"
                                                    wire:click="mostrarQueja({{ $suggestion->id }})" target="_blank">
                                                    Ver Reclamo
                                                </button>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <!-- Enlaces de paginación -->
                            {{ $suggestions->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
