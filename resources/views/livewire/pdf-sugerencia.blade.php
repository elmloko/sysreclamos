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

        th,
        td {
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
            <h2>LIBRO DE SUGERENCIAS - REPORTE PAGWEB</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>
    <table>
        <tbody>
            @foreach ($suggestions as $suggestion)
                <tr>
                    <th style="border: none; text-align: left; font-weight: normal; line-height: 0.5;">
                        <p>Nombre del Usuario: {{ auth()->user()->name }}</p>
                    </th>
                    <th style="border: none; text-align: left; font-weight: normal; line-height: 0.5;">Regional:
                        {{ auth()->user()->city }}</th>
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
            <th>Codificacion</th>
            <th>Cliente</th>
            <th>Direccion</th>
            <th>Email</th>
            <th>Teléfono</th>
            <th>Carnet de Identidad</th>
            <th>Pais</th>
            <th>Codigo Postal</th>
            <th>Descripcion</th>
            <th>Estado</th>
            <th>Creado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($suggestions as $suggestion)
            <tr>
                <td>{{ $suggestion->correlativo }}</td>
                <td>{{ $suggestion->fullName }}</td>
                <td>{{ $suggestion->address }}</td>
                <td>{{ $suggestion->email }}</td>
                <td>{{ $suggestion->phone }}</td>
                <td>{{ $suggestion->identityCard }}</td>
                <td>{{ $suggestion->codepostal }}</td>
                <td>{{ $suggestion->country }}</td>
                <td>{{ $suggestion->description }}</td>
                <td>{{ $suggestion->estado }}</td>
                <td>{{ $suggestion->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>

</html>
