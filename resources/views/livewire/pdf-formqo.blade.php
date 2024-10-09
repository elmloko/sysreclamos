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
            margin-bottom: 12px;
            font-size: 12px;
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

        .special-text {
            text-align: center;
            font-size: 12px;
            border: none !important;
        }
        .wrap-text {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .correlativo {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            margin-right: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images/images.png') }}" alt="" width="150" height="50">
        </div>
        <div class="title">
            <h2>FORMULARIO DIRECTO DE QUEJAS</h2>
            <h2>OPERARTIVA</h2>
            <h2>Q2 - FORMULARIO DIRECTO</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
        <div class="correlativo">
            {{ $complaint->correlativo }}
        </div>
    </div>

    <h5>Información del Cliente</h5>
    <!-- Primera Tabla: Información del Remitente -->
    <table>
        <tr>
            <th>Remitente</th>
            <td>{{ $complaint->cliente }}</td>
        </tr>
        <tr>
            <th>Teléfono del Remitente</th>
            <td>{{ $complaint->telf }}</td>
        </tr>
        <tr>
            <th>Email del Remitente</th>
            <td>{{ $complaint->email }}</td>
        </tr>
        <tr>
            <th>Carnet Identidad</th>
            <td>{{ $complaint->ci }}</td>
        </tr>
    </table>

    <h5>Información de la Queja</h5>
    <!-- Segunda Tabla: Información del Destinatario -->
    <table>
        <tr>
            <th style="width: 40%;">Funcionario</th>
            <td style="width: 60%;">{{ $complaint->funcionario }}</td>
        </tr>
        <tr>
            <th>Queja</th>
            <td>{{ $complaint->queja }}</td>
        </tr>
        <tr>
            <th>Fecha:</th>
            <td>{{ $complaint->created_at }}</td>
        </tr>
        <tr>
            <th>Usuario:</th>
            <td>{{ Auth::user()->name }}</td>
        </tr>
    </table>

    <br>
    <br>
    <table>
        <td>
            <p class="special-text">__________________________</p>
            <p class="special-text">{{ $complaint->cliente }}</p>
        </td>
    </table>
</body>

</html>
