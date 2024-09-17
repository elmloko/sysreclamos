@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Casos Cerrados
@endsection

@section('content')
    @livewire('bajareclamos')
    @include('footer')
@stop
