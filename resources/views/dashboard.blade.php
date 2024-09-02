@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Sistema de Informacion y Reclamos de la AGBC</h1>
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

@section('css')

@stop

@section('js')

@stop
