@extends('adminlte::page')

@section('title', 'Crear Seguimiento')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Crear Nuevo Seguimiento</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Nuevo Seguimiento</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('seguimiento.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="claims_id" value="{{ $claim->id }}">
                        
                            <div class="form-group">
                                <label for="seguimiento">Seguimiento del caso</label>
                                <textarea name="seguimiento" class="form-control" rows="4" maxlength="255"></textarea>
                            </div>
                        
                            <div class="form-group">
                                <label for="acciones">Acciones tomadas hasta el tiempo</label>
                                <textarea name="acciones" class="form-control" rows="4" maxlength="255"></textarea>
                            </div>
                        
                            <div class="form-group">
                                <label for="docs">Documentos</label>
                                <input type="file" name="docs[]" class="form-control" multiple>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Seguimiento</button>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
