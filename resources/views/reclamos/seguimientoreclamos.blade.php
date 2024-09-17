@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Seguimientos
@endsection

@section('content')
    @livewire('seguimientoreclamos')
    @include('footer')
@stop
