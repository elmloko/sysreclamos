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
                                @hasrole('SuperAdmin|Administrador|Reclamos')
                                    <button type="button" class="btn btn-warning ml-2" data-toggle="modal"
                                        data-target="#tipoReclamoModal">Cambiar a Reclamos</button>
                                @endhasrole
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
                                        <th><input type="checkbox" wire:model="selectAll"></th>
                                        <th>Codificacion</th>
                                        <th>Denunciante</th>
                                        <th>Teléfono Denunciante</th>
                                        <th>Email Denunciante</th>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Código de Rastreo</th>
                                        <th>Tipo de Envio</th>
                                        @hasrole('SuperAdmin|Administrador')
                                            <th>Calificacion</th>
                                            <th>Ciudad</th>
                                        @endhasrole
                                        <th>Estado</th>
                                        <th>Creado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($claims as $claim)
                                        <tr>
                                            <td><input type="checkbox" wire:model="selectedClaims" value="{{ $claim->id }}"></td>
                                            <td>{{ $claim->correlativo }}</td>
                                            <td>{{ $claim->denunciante }}</td>
                                            <td>{{ $claim->denunciantetelf }}</td>
                                            <td>{{ $claim->denuncianteemail }}</td>
                                            <td>{{ $claim->origen }}</td>
                                            <td>{{ $claim->destino }}</td>
                                            <td>{{ $claim->codigo }}</td>
                                            <td>{{ $claim->tipo_envio }}</td>
                                            @hasrole('SuperAdmin|Administrador')
                                                <td>{{ $claim->feedback ?? 0 }}</td>
                                                <td>{{ $claim->ciudad }}</td>
                                            @endhasrole
                                            <td>{{ $claim->estado }}</td>
                                            <td>{{ $claim->created_at }}</td>
                                            <td style="background-color: {{ $claim->color }}; color: white;">
                                                {{ $claim->time_difference }} {{ $claim->time_unit }}
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
    <!-- Modal para seleccionar el tipo de reclamo -->
    <div class="modal fade" id="tipoReclamoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">TIPO DE RECLAMOS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tipo_reclamo">Seleccione el tipo de reclamo</label>
                        <select wire:model="tipoReclamo" class="form-control" id="tipo_reclamo">
                            <option value="">Seleccione</option>
                            <option value="ENTRADA">ENTRADA</option>
                            <option value="SALIDA">SALIDA</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="guardarTipoReclamo">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('modal-close', event => {
            $('#tipoReclamoModal').modal('hide');
        });
    </script>
</div>
