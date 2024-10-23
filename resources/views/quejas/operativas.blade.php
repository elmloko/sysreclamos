@extends('adminlte::page')

@section('title', 'SIRECO')

@section('template_title')
    Quejas OP
@endsection

@section('content')
    @livewire('operativas')
    @include('footer')
@stop
