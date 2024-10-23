@extends('adminlte::page')

@section('title', 'SIRECO')

@section('content_header')
    <h1>Sistema de Informacion, Consultas, Quejas y Reclamos de la AGBC</h1>
@stop

@section('content')
    @hasrole('SuperAdmin|Administrador')
        @livewire('estadisticas')
    @endhasrole
    @hasrole('SuperAdmin|Reclamos|Informaciones')
        @livewire('dashboard')
    @endhasrole
    @include('footer')
@stop
