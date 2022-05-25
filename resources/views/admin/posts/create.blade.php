@extends('adminlte::page')

@section('title', 'Blog')

@section('content_header')
    <h1>Crear Post</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route'=>'admin.posts.store','autocomplete'=>'off', 'files'=> true]) !!}
                {{-- la validacion de user_id se haria con el observer --}}
                {{-- {!! Form::hidden('user_id', auth()->user()->id) !!} --}}
                @include('admin.posts.partials.form')
                {!! Form::submit('Crear Post', ['class'=>'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <style>
        .image-wrapper{
            position: relative;
            padding-bottom: 56.25%;
        }
        .image-wrapper img{
            position: absolute;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
    </style>
@stop

@section('js')
    <script src="{{asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js')}}" ></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready( function() {
            $("#name").stringToSlug({
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                space: '-'
            });
        });

        ClassicEditor
        .create( document.querySelector( '#extract' ) )
        .catch( error => {
            console.error( error );
        } );
        
        ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );

        //Cambiar imagen al momento de cargar
        //se mantiene a la escucha y cuando seleccionamos un archivo activa la funcion 
        document.getElementById("file").addEventListener('change', cambiarImagen);
        function cambiarImagen(event){
            //transforma la imagen seleccionada en base 64
            var file = event.target.files[0];

            var reader = new FileReader();
            reader.onload = (event)=>{
                //reeempla el valor del attibuto src con la imagen base64
                document.getElementById("picture").setAttribute('src', event.target.result);
            };
            reader.readAsDataURL(file);
        }
    </script>
@stop
