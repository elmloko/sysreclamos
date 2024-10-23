@extends('adminlte::page')

@section('title', 'SIRECO')

@section('template_title')
    Casos Cerrados
@endsection

@section('content')
    @livewire('bajareclamos')
    @include('footer')
@stop
