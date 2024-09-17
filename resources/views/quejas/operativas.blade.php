@extends('adminlte::page')

@section('title', 'Estadísticas de Paquetes')

@section('template_title')
    Quejas OP
@endsection

@section('content')
    @livewire('operativas')
    @include('footer')
@stop
