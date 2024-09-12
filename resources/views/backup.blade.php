@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Sistema de Informacion y Reclamos de la AGBC</h1>
@stop

@section('content')
<div class="card shadow-lg">
    <div class="card-header bg-primary text-white">
        <h4>Generar Backup del Sistema</h4>
    </div>
    <div class="card-body">
        <p>Haz clic en el botón de abajo para crear un backup completo del sistema.</p>
        <form id="backupForm" action="{{ route('crear-backup') }}" method="GET">
            @csrf
            <button id="backupButton" type="submit" class="btn btn-success btn-lg w-100">
                <i class="fas fa-database"></i> Crear Backup
            </button>
        </form>

        {{-- Barra de progreso --}}
        <div id="progressBar" class="progress mt-3" style="display:none;">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" 
                style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</div>

{{-- Mensajes de éxito o error --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@include('footer')
@stop

@section('css')

@stop

@section('js')
<script>
    document.getElementById('backupForm').addEventListener('submit', function() {
        // Mostrar barra de progreso
        document.getElementById('progressBar').style.display = 'block';

        // Deshabilitar botón de backup
        document.getElementById('backupButton').disabled = true;

        // Simular progreso (esto es solo un ejemplo, deberías manejar el estado real desde el backend)
        var progressBar = document.querySelector('.progress-bar');
        var width = 0;
        var interval = setInterval(function() {
            if (width >= 100) {
                clearInterval(interval);
            } else {
                width++;
                progressBar.style.width = width + '%';
                progressBar.setAttribute('aria-valuenow', width);
            }
        }, 100); // Simulación de progreso
    });
</script>
@stop
