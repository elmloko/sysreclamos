@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Sugerencias
@endsection

@section('content')
    @livewire('sugerencia')
    @include('footer')
@stop
