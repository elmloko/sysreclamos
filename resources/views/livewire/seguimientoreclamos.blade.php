<div class="container-fluid">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Seguimiento de Reclamos AGBC</h1>
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
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        {{-- <th><input type="checkbox" wire:model="selectAll"></th> --}}
                                        <th>Codificacion</th>
                                        <th>Remitente</th>
                                        <th>Teléfono Remitente</th>
                                        <th>Email Remitente</th>
                                        <th>Origen</th>
                                        <th>Destinatario</th>
                                        <th>Teléfono Destinatario</th>
                                        <th>Email Destinatario</th>
                                        <th>Dirección Destinatario</th>
                                        <th>Código Postal</th>
                                        <th>Destino</th>
                                        <th>Código</th>
                                        <th>Fecha de Envío</th>
                                        <th>Contenido</th>
                                        <th>Valor</th>
                                        <th>Actualizado</th>
                                        <th>Acciones</th>
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
                                            <td>{{ $claim->email_r }}</td>
                                            <td>{{ $claim->origen }}</td>
                                            <td>{{ $claim->destinatario }}</td>
                                            <td>{{ $claim->telf_destinatario }}</td>
                                            <td>{{ $claim->email_d }}</td>
                                            <td>{{ $claim->direccion_d }}</td>
                                            <td>{{ $claim->codigo_postal }}</td>
                                            <td>{{ $claim->destino }}</td>
                                            <td>{{ $claim->codigo }}</td>
                                            <td>{{ $claim->fecha_envio }}</td>
                                            <td>{{ $claim->contenido }}</td>
                                            <td>{{ $claim->valor }}</td>
                                            <td>{{ $claim->updated_at }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info"
                                                    wire:click="mostrarReclamo({{ $claim->id }})" target="_blank">
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
                            {{ $claims->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
