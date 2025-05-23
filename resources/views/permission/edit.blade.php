@extends('adminlte::page')
@section('title', 'SIRECO')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Editar') }} Permisos</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('permissions.update', $permission->id) }}" role="form"
                            enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('permission.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('footer')
@endsection
