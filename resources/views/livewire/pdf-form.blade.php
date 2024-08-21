<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Reclamo</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .title {
            text-align: center;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            <h2>BOLETIN DE VERIFICACION INTERNACIONAL</h2>
            <h2>CN08 - FORMULARIO DIRECTO</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>

    <h5>Información del Remitente</h5>
    <!-- Primera Tabla: Información del Remitente -->
    <table>
        <tr>
            <th>Remitente</th>
            <td>{{ $claim->remitente }}</td>
        </tr>
        <tr>
            <th>Teléfono del Remitente</th>
            <td>{{ $claim->telf_remitente }}</td>
        </tr>
        <tr>
            <th>Email del Remitente</th>
            <td>{{ $claim->email_r }}</td>
        </tr>
    </table>

    <h5>Información del Destinatario</h5>
    <!-- Segunda Tabla: Información del Destinatario -->
    <table>
        <tr>
            <th>Origen</th>
            <td>{{ $claim->origen }}</td>
        </tr>
        <tr>
            <th>Destinatario</th>
            <td>{{ $claim->destinatario }}</td>
        </tr>
        <tr>
            <th>Teléfono del Destinatario</th>
            <td>{{ $claim->telf_destinatario }}</td>
        </tr>
        <tr>
            <th>Email del Destinatario</th>
            <td>{{ $claim->email_d }}</td>
        </tr>
        <tr>
            <th>Dirección del Destinatario</th>
            <td>{{ $claim->direccion_d }}</td>
        </tr>
        <tr>
            <th>Código Postal</th>
            <td>{{ $claim->codigo_postal }}</td>
        </tr>
        <tr>
            <th>Destino</th>
            <td>{{ $claim->destino }}</td>
        </tr>
    </table>

    <h5>Detalles del Envío</h5>
    <!-- Tercera Tabla: Detalles del Envío -->
    <table>
        <tr>
            <th>Código</th>
            <td>{{ $claim->codigo }}</td>
        </tr>
        <tr>
            <th>Fecha de Envío</th>
            <td>{{ $claim->fecha_envio }}</td>
        </tr>
        <tr>
            <th>Contenido</th>
            <td>{{ $claim->contenido }}</td>
        </tr>
        <tr>
            <th>Valor</th>
            <td>{{ $claim->valor }}</td>
        </tr>
    </table>
</body>

</html>
