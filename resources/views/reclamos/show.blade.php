@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Estadísticas de Paquetería Postal
@endsection

@section('content')
    <div class="container">
        <h1>Detalle del Reclamo</h1>
        <p><strong>ID:</strong> {{ $claim->id }}</p>
        <p><strong>Remitente:</strong> {{ $claim->remitente }}</p>
        <p><strong>Teléfono Remitente:</strong> {{ $claim->telf_remitente }}</p>
        <p><strong>Email Remitente:</strong> {{ $claim->email_r }}</p>
        <p><strong>Origen:</strong> {{ $claim->origen }}</p>
        <p><strong>Destinatario:</strong> {{ $claim->destinatario }}</p>
        <p><strong>Teléfono Destinatario:</strong> {{ $claim->telf_destinatario }}</p>
        <p><strong>Email Destinatario:</strong> {{ $claim->email_d }}</p>
        <p><strong>Dirección Destinatario:</strong> {{ $claim->direccion_d }}</p>
        <p><strong>Código Postal:</strong> {{ $claim->codigo_postal }}</p>
        <p><strong>Destino:</strong> {{ $claim->destino }}</p>
        <p><strong>Código:</strong> {{ $claim->codigo }}</p>
        <p><strong>Fecha de Envío:</strong> {{ $claim->fecha_envio }}</p>
        <p><strong>Contenido:</strong> {{ $claim->contenido }}</p>
        <p><strong>Valor:</strong> {{ $claim->valor }}</p>
        <p><strong>Creado:</strong> {{ $claim->created_at }}</p>
    </div>
    @include('footer')
@stop
