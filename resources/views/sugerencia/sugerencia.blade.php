@extends('adminlte::page')

@section('title', 'SIRECO')

@section('template_title')
    Sugerencias
@endsection

@section('content')
    @livewire('sugerencia')
    @include('footer')
@stop
