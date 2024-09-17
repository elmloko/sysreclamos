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
                            <div class="float-left d-flex align-items-center">
                                <input type="text" wire:model="searchTerm" placeholder="Buscar..."
                                    class="form-control" style="margin-right: 10px;">
                                <button type="button" class="btn btn-primary" wire:click="$refresh">Buscar</button>
                            </div>
                            <div class="float-right d-flex align-items-center">
                                <input type="date" wire:model="selectedDate" class="form-control">
                                <button type="button" class="btn btn-primary ml-2" wire:click="exportPdf">Exportar a
                                    PDF</button>
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                    data-target="#cnModal">Crear Reclamo</button>
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
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Código</th>
                                        <th>Fecha de Envío</th>
                                        <th>Contenido</th>
                                        <th>Valor</th>
                                        @hasrole('SuperAdmin|Administrador')
                                            <th>Ciudad</th>
                                        @endhasrole
                                        <th>Estado</th>
                                        <th>Tiempo Trascurrido</th>
                                        <th>Fecha Recibido</th>
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
                                            <td>{{ $claim->origen }}</td>
                                            <td>{{ $claim->destino }}</td>
                                            <td>{{ $claim->codigo }}</td>
                                            <td>{{ $claim->fecha_envio }}</td>
                                            <td>{{ $claim->contenido }}</td>
                                            <td>{{ $claim->valor }}</td>
                                            @hasrole('SuperAdmin|Administrador')
                                                <td>{{ $claim->ciudad }}</td>
                                            @endhasrole
                                            <td>{{ $claim->estado }} - {{ $claim->tipo_reclamo }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($claim->fecha_envio)->diffInDays(\Carbon\Carbon::now()) }}
                                                días
                                            </td>
                                            <td>{{ $claim->updated_at }}</td>
                                            <td>
                                                <div class="d-flex" role="group" aria-label="Acciones">
                                                    <button type="button" class="btn btn-info mr-2"
                                                        wire:click="mostrarReclamo({{ $claim->id }})"
                                                        target="_blank">
                                                        Ver Reclamo
                                                    </button>
                                                    @hasrole('SuperAdmin|Administrador')
                                                        <button type="button" class="btn btn-danger"
                                                            wire:click="darDeBaja({{ $claim->id }})">
                                                            Cerrar Caso
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

    <!-- Modal Registro CN08 -->
    <div class="modal fade" id="cnModal" tabindex="-1" aria-labelledby="cnModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cnModalLabel">REGISTRO DE RECLAMO - FORMULARIO DIRECTO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="cnForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="remitente">REMITENTE</label>
                                    <input type="text" class="form-control" id="remitente" wire:model="remitente"
                                        style="text-transform: uppercase;" required>
                                    <div class="invalid-feedback">Por favor, ingresa el nombre del remitente.</div>
                                </div>

                                <div class="form-group">
                                    <label for="telf_remitente">TELÉFONO DEL REMITENTE</label>
                                    <input type="text" class="form-control" id="telf_remitente"
                                        wire:model="telf_remitente" maxlength="15" required>
                                    <div class="invalid-feedback">Por favor, ingresa un número de teléfono válido.</div>
                                </div>

                                <div class="form-group">
                                    <label for="email_r">EMAIL DEL REMITENTE</label>
                                    <input type="email" class="form-control" id="email_r" wire:model="email_r">
                                    <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido.</div>
                                </div>

                                <div class="form-group">
                                    <label for="origen">ORIGEN</label>
                                    <input type="text" class="form-control" id="origen" wire:model="origen"
                                        style="text-transform: uppercase;" required>
                                    <div class="invalid-feedback">Por favor, ingresa el origen.</div>
                                </div>

                                <div class="form-group">
                                    <label for="contenido">CONTENIDO PAQUETE</label>
                                    <input type="text" class="form-control" id="contenido" wire:model="contenido"
                                        style="text-transform: uppercase;" required>
                                    <div class="invalid-feedback">Por favor, ingresa el contenido del paquete.</div>
                                </div>

                                <div class="form-group">
                                    <label for="valor">VALOR</label>
                                    <input type="number" step="0.01" class="form-control" id="valor"
                                        wire:model="valor" required>
                                    <div class="invalid-feedback">Por favor, ingresa el valor del paquete.</div>
                                </div>

                                <div class="form-group">
                                    <label for="fecha_envio">FECHA DE ENVÍO</label>
                                    <input type="date" class="form-control" id="fecha_envio"
                                        wire:model="fecha_envio" required>
                                    <div class="invalid-feedback">Por favor, selecciona la fecha de envío.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="destinatario">DESTINATARIO</label>
                                    <input type="text" class="form-control" id="destinatario"
                                        wire:model="destinatario" style="text-transform: uppercase;" required>
                                    <div class="invalid-feedback">Por favor, ingresa el nombre del destinatario.</div>
                                </div>

                                <div class="form-group">
                                    <label for="telf_destinatario">TELÉFONO DEL DESTINATARIO</label>
                                    <input type="text" class="form-control" id="telf_destinatario"
                                        wire:model="telf_destinatario" maxlength="15">
                                    <div class="invalid-feedback">Por favor, ingresa un número de teléfono válido.
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email_d">EMAIL DEL DESTINATARIO</label>
                                    <input type="email" class="form-control" id="email_d" wire:model="email_d">
                                    <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido.
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="destino">DESTINO</label>
                                    <input type="text" class="form-control" id="destino" wire:model="destino"
                                        style="text-transform: uppercase;" required>
                                    <div class="invalid-feedback">Por favor, ingresa el destino.</div>
                                </div>

                                <div class="form-group">
                                    <label for="direccion_d">DIRECCIÓN DEL DESTINATARIO</label>
                                    <input type="text" class="form-control" id="direccion_d"
                                        wire:model="direccion_d" style="text-transform: uppercase;" required>
                                    <div class="invalid-feedback">Por favor, ingresa la dirección del destinatario.
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="codigo_postal">CÓDIGO POSTAL</label>
                                    <input type="number" class="form-control" id="codigo_postal"
                                        wire:model="codigo_postal">
                                </div>

                                <div class="form-group">
                                    <label for="codigo">CÓDIGO</label>
                                    <input type="text" class="form-control" id="codigo" wire:model="codigo"
                                        style="text-transform: uppercase;" required>
                                    <div class="invalid-feedback">Por favor, ingresa el código.</div>
                                </div>

                                <div class="form-group">
                                    <label for="tipo_reclamo">TIPO DE RECLAMOS</label>
                                    <select class="form-control" id="tipo_reclamo" wire:model="tipo_reclamo"
                                        required>
                                        <option value="">Seleccionar</option>
                                        <option value="ENTRADA">ENTRADA</option>
                                        <option value="SALIDA">SALIDA</option>
                                    </select>
                                    <div class="invalid-feedback">Por favor, selecciona el tipo de reclamo.</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="reclamo">DESCRIPCIÓN DEL RECLAMO</label>
                            <textarea class="form-control" id="reclamo" wire:model="reclamo" rows="5"
                                style="text-transform: uppercase;" required></textarea>
                            <div class="invalid-feedback">Por favor, ingresa la descripción del reclamo.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CERRAR</button>
                    <button type="button" class="btn btn-primary" onclick="validarFormulario()">GUARDAR
                        REGISTRO</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validarFormulario() {
            const form = document.getElementById('cnForm');
            if (form.checkValidity() === false) {
                // Si hay errores, mostrar las alertas de validación
                form.classList.add('was-validated');
            } else {
                // Enviar el formulario si es válido
                @this.savecn(); // Llamada a Livewire si el formulario es válido
            }
        }
    </script>

    <script>
        window.addEventListener('close-modal', event => {
            $('#cnModal').modal('hide');
        });
    </script>
</div>
