@extends('adminlte::page')
@section('title', 'SIRECO')
@section('template_title')
    Eventos SIRECO
@endsection

@section('content')
    @livewire('events')
    @include('footer')
@endsection
