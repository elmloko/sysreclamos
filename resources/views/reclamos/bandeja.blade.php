@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Bandeja
@endsection

@section('content')
    @livewire('bandejareclamos')
    @include('footer')
@stop
