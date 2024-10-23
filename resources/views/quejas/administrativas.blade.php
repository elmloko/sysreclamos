@extends('adminlte::page')

@section('title', 'SIRECO')

@section('template_title')
    Quejas ADM
@endsection

@section('content')
    @livewire('administrativas')
    @include('footer')
@stop
