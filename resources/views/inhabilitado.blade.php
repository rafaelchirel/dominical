@extends('layouts.app')

@section('content')

    <div class="text-center" style="margin-top:2%; ">

        <figure>
            <img src="{{ asset('img/inhabilitado.jpg') }}" style="width: 20%; height: 20%; border: 1px solid black;">
            <figcaption>
            	<b>USUARIO INHABILITADO</b>
            	<br>
            	<b>CONSULTAR CON UN ADMINISTRADOR</b>
            </figcaption>
        </figure>

        <div class="text-center social-btn">
                <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-thumbtack"></i>&nbsp;<b>Regresar a Login</b></a>
        </div>
    </div>

@endsection

@section('js')

    <script>
    
    </script>

@endsection
