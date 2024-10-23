@extends('adminlte::page')

@section('title', 'SIRECO')

@section('template_title')
    Bandeja
@endsection

@section('content')
    @livewire('bandejareclamos')
    @include('footer')
@stop
