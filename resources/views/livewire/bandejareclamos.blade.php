<div class="container-fluid">
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
                            <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
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
                    <th>Creado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($claims as $claim)
                    <tr>
                        <td>{{ $claim->id }}</td>
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
                        <td>{{ $claim->created_at }}</td>
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
