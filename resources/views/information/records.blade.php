@extends('adminlte::page')

@section('title', 'SIRECO')

@section('template_title')
    Informaciones
@endsection

@section('content')
    @livewire('records')
    @include('footer')
@stop
