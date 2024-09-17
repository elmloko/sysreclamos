@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Informaciones
@endsection

@section('content')
    @livewire('records')
    @include('footer')
@stop
