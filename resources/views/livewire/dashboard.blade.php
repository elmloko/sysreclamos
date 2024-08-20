<div
    style="max-width: 1000px; margin: 20px auto; padding: 20px; background-color: #f9f9f9; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <input type="text" wire:model="codigo" placeholder="Ingresa el código"
            style="flex: 1; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 4px; margin-right: 10px;">
        <button wire:click="search"
            style="padding: 10px 15px; font-size: 16px; background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer;">
            Buscar
        </button>
    </div>

    @if (!empty($codigo) && !empty($events))
        <h2 style="text-align: center; margin-bottom: 15px;">Eventos del código: {{ $codigo }}</h2>
    @endif

    @if ($additionalInfo)
        <div style="margin-bottom: 20px;">
            <h3 style="text-align: center;">Información Adicional</h3>
            <table style="width: 100%; border-collapse: collapse; margin: 0 auto; text-align: left;">
                <thead>
                    <tr style="background-color: #f1f1f1;">
                        <th style="padding: 10px;">Destinatario</th>
                        <th style="padding: 10px;">Estado</th>
                        <th style="padding: 10px;">Teléfono</th>
                        <th style="padding: 10px;">Ciudad</th>
                        <th style="padding: 10px;">Ventanilla</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 10px;">{{ $additionalInfo['DESTINATARIO'] }}</td>
                        <td style="padding: 10px;">{{ $additionalInfo['ESTADO'] }}</td>
                        <td style="padding: 10px;">{{ $additionalInfo['TELEFONO'] }}</td>
                        <td style="padding: 10px;">{{ $additionalInfo['CUIDAD'] }}</td>
                        <td style="padding: 10px;">{{ $additionalInfo['VENTANILLA'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #007bff; color: #fff;">
                <th style="padding: 10px; text-align: left;">Acción</th>
                <th style="padding: 10px; text-align: left;">Descripción</th>
                <th style="padding: 10px; text-align: left;">Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($events as $event)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="padding: 10px;">{{ $event['action'] }}</td>
                    <td style="padding: 10px;">{{ $event['descripcion'] }}</td>
                    <td style="padding: 10px;">{{ $event['updated_at'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="padding: 10px; text-align: center;">No se encontraron eventos para este
                        código.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="text-align: right; margin-top: 20px;">
        @if ($additionalInfo)
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#atmModal">
                Registro SAC
            </button>
        @else
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sacModal">
                Registro SAC
            </button>
        @endif
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#llamadaModal">
            Registro Llamadas
        </button>
    </div>

    <!-- Modal Registro ATM -->
    <div class="modal fade" id="atmModal" tabindex="-1" aria-labelledby="atmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="atmModalLabel">Registro de Atención a los Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" class="form-control" id="codigo" value="{{ $codigo }}"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="codigo">Nombre Completo</label>
                            <input type="text" class="form-control" id="codigo"
                                value="{{ $additionalInfo['DESTINATARIO'] ?? '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Último Estado</label>
                            <input type="text" class="form-control" id="nombre"
                                value="{{ $additionalInfo['ESTADO'] ?? '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono"
                                value="{{ $additionalInfo['TELEFONO'] ?? '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="ciudad">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad"
                                value="{{ $additionalInfo['CUIDAD'] ?? '' }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="text" class="form-control" id="fecha"
                                value="{{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="saveData">
                        Habilitar Feedback
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Registro Llamadas -->
    <div class="modal fade" id="llamadaModal" tabindex="-1" aria-labelledby="llamadaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="llamadaModalLabel">Registro de Llamadas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" class="form-control" id="codigo" wire:model="codigo">
                        </div>
                        <div class="form-group">
                            <label for="destinatario">Destinatario</label>
                            <input type="text" class="form-control" id="destinatario" wire:model="destinatario">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="number" class="form-control" id="telefono" wire:model="telefono"
                                pattern="\d*" maxlength="8">
                        </div>
                        <div class="form-group">
                            <label for="last_description">Descripción</label>
                            <textarea class="form-control" id="last_description" wire:model="last_description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" id="estado" value="LLAMADA" readonly>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="text" class="form-control" id="fecha"
                                value="{{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="saveLlamada">
                        Guardar Registro
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Registro Llamadas -->
    <div class="modal fade" id="sacModal" tabindex="-1" aria-labelledby="sacModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sacModalLabel">Registro de atencion al usuario (Manual)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="codigo">Código</label>
                            <input type="text" class="form-control" id="codigo" wire:model="codigo">
                        </div>
                        <div class="form-group">
                            <label for="destinatario">Destinatario</label>
                            <input type="text" class="form-control" id="destinatario" wire:model="destinatario">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="number" class="form-control" id="telefono" wire:model="telefono"
                                pattern="\d*" maxlength="8">
                        </div>
                        <div class="form-group">
                            <label for="last_description">Descripción</label>
                            <textarea class="form-control" id="last_description" wire:model="last_description"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" id="estado" value="SAC MANUAL" readonly>
                        </div>
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="text" class="form-control" id="fecha"
                                value="{{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" wire:click="savesac">
                        Guardar Registro
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Calificando -->
    <div class="modal fade" id="calificandoModal" tabindex="-1" aria-labelledby="calificandoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 id="calificandoModalLabel">Calificando...</h5>
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('close-modal', event => {
        $('#atmModal').modal('hide'); // Cierra el modal de Registro ATM
        $('#sacModal').modal('hide'); // Cierra el modal de SAC Manual
        $('#llamadaModal').modal('hide'); // Cierra el modal de Registro de Llamadas
    });

    document.addEventListener('open-calificando-modal', event => {
        $('#calificandoModal').modal('show'); // Abre el modal de Calificando
    });

    document.addEventListener('close-calificando-modal', event => {
        $('#calificandoModal').modal('hide'); // Cierra el modal de Calificando
    });
</script>