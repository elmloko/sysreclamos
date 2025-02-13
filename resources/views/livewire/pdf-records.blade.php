<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Registros</title>
    <style>
        /* Estilos para la tabla */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #000;
            padding: 5px;
        }

        .first-table th,
        .first-table td {
            border: 1px solid #000;
            padding: 5px;
            line-height: 0.5;
        }

        thead {
            background-color: #f2f2f2;
        }

        /* Estilos para la página en formato horizontal */
        @page {
            size: landscape;
        }

        /* Estilos para la imagen y el título */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            line-height: 0.5;
        }

        .title {
            text-align: center;
        }
        .firma {
            text-align: center;
            margin-top: 20px;
            line-height: 0;
        }
        .date {
            border: none;
            line-height: 0.5;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/images.png') }}" alt="" width="150" height="50">
        </div>
        <div class="title">
            <h2>REGISTRO DE ATENCION A LOS USUARIOS</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <table>
        <tbody>
            @foreach($records as $record)
            <tr>
                <th style="border: none; text-align: left; font-weight: normal; line-height: 0.5;">
                    <p>Nombre del Usuario: {{ auth()->user()->name }}</p>
                </th>
                <th style="border: none; text-align: left; font-weight: normal; line-height: 0.5;">Regional: {{ auth()->user()->city }}</th>
            </tr>
            <tr>
                <td style="border: none; text-align: left; font-weight: normal; line-height: 0.5;">
                    <p>Fecha: {{ now()->format('Y-m-d H:i') }}</p>
                </td>
                <td style="border: none; text-align: left; font-weight: normal; line-height: 0.5;">

                </td>
            </tr>
            @break
    @endforeach
        </tbody>
    </table>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Codificacion</th>
                <th>Código</th>
                <th>Destinatario</th>
                <th>Último Evento</th>
                <th>Teléfono</th>
                <th>Ciudad</th>
                <th>Ventanilla</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Feedback</th>
                <th>Creado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->correlativo }}</td>
                    <td>{{ $record->codigo }}</td>
                    <td>{{ $record->destinatario }}</td>
                    <td>{{ $record->last_event }}</td>
                    <td>{{ $record->telefono }}</td>
                    <td>{{ $record->ciudad }}</td>
                    <td>{{ $record->ventanilla }}</td>
                    <td>{{ $record->last_description }}</td>
                    <td>
                        @if($record->estado == 'SAC AUTOMATICO')
                            AUTOMATICO
                        @elseif($record->estado == 'SAC MANUAL')
                            MANUAL
                        @elseif($record->estado == 'LLAMADA')
                            LLAMADA
                        @else
                            {{ $record->estado }}
                        @endif
                    </td>                    
                    <td>{{ $record->feedback }}</td>
                    <td>{{ $record->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
