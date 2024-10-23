@extends('adminlte::page')

@section('title', 'SIRECO')

@section('template_title')
    Todo
@endsection

@section('content')
    @livewire('all')
    @include('footer')
@stop
