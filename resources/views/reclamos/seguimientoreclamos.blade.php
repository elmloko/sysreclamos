@extends('adminlte::page')

@section('title', 'SIRECO')

@section('template_title')
    Seguimientos
@endsection

@section('content')
    @livewire('seguimientoreclamos')
    @include('footer')
@stop
