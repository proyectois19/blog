@extends('adminlte::page')

@section('title', 'Blog')

@section('content_header')
    <h1>Crear Etiquetas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- Lo hacemos con laravel collective --}}
            {!! Form::open(['route'=>'admin.tags.store']) !!}
                @include('admin.tags.partials.form')
                {!! Form::submit('Crear Etiqueta', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script src="{{asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js')}}" ></script>
    <script>
        $(document).ready( function() {
            $("#name").stringToSlug({
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                space: '-'
            });
        });
    </script>
@stop