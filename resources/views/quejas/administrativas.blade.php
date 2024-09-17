@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Quejas ADM
@endsection

@section('content')
    @livewire('administrativas')
    @include('footer')
@stop
