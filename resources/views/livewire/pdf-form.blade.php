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
            margin-bottom: 6px;
            /* Reducir el espacio entre tablas */
            font-size: 10px;
        }

        th,
        td {
            padding: 4px;
            /* Reducir el padding para menos espacio */
            text-align: left;
            border: 1px solid #ddd;
        }

        h5 {
            margin: 4px 0;
            /* Reducir el margen de los títulos */
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

        .special-text {
            text-align: center;
            font-size: 10px;
            border: none !important;
            margin: 2px 0;
            /* Reducir márgenes */
        }

        .correlativo {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            margin-right: 10px;
            margin-top: 10px;
            /* Reducir margen superior */
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/images.png') }}" alt="" width="150" height="50">
        </div>
        <div class="title">
            <h4>BOLETIN DE VERIFICACION INTERNACIONAL</h4>
            <h4>FORMULARIO DIRECTO DE RECLAMACIONES</h4>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
        <div class="correlativo">
            {{ $claim->correlativo }}
        </div>
    </div>

    <h5>Información del Remitente</h5>
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

    <h5>Detalles del Reclamo</h5>
    <table>
        <tr>
            <th>Nombres del Denunciante</th>
            <td>{{ $claim->denunciante }}</td>
        </tr>
        <tr>
            <th>Carnet de Identidad del Denunciante</th>
            <td>{{ $claim->denuncianteci }}</td>
        </tr>
        <tr>
            <th>Detalles del Reclamo</th>
            <td>{{ $claim->reclamo }}</td>
        </tr>
        <tr>
            <th>Fecha:</th>
            <td>{{ $claim->created_at }}</td>
        </tr>
        <tr>
            <th>Usuario:</th>
            <td>{{ Auth::user()->name }}</td>
        </tr>
    </table>
    <table>
        <td>
            <p class="special-text">__________________________</p>
            <p class="special-text">{{ $claim->remitente }}</p>
        </td>
    </table>
</body>

</html>
