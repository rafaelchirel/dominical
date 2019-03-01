@extends('layouts.app')

@section('content')

    <div class="login-form">
        <img src="{{ asset('img/banner.png') }}" width="100%;">

        <form onsubmit="return sendform(event)" method="POST" action="{{ route('register') }}" aria-label="{{ __('Register') }}">

            @csrf

            <h2 class="text-center">Registrar Usuario</h2>

            <div class="form-group">
                <div id="nombre-error" class="{{ $errors->has('nombre') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <input id="nombre" type="text" class="form-control" placeholder="Nombre" name="nombre" value="{{ old('nombre') }}" autofocus onclick="limpiarError()">
                        <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                    </div>
                        
                    @if ($errors->has('nombre'))
                        <span class="message-error invalid-feedback" role="alert">
                            <strong style="color: #D22F34;">{{ $errors->first('nombre') }}</strong>
                        </span>
                    @endif

                </div>
            </div> 

            <div class="form-group">
                <div id="apellido-error" class="{{ $errors->has('nombre') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <input id="apellido" type="text" class="form-control" placeholder="Apellido" name="apellido" value="{{ old('apellido') }}" autofocus onclick="limpiarError()">
                        <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                    </div>
                        
                    @if ($errors->has('apellido'))
                        <span class="message-error invalid-feedback" role="alert">
                            <strong style="color: #D22F34;">{{ $errors->first('apellido') }}</strong>
                        </span>
                    @endif

                </div>
            </div>     

            <div class="form-group">
                <div id="pregunta-error" class="{{ $errors->has('pregunta') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <input id="pregunta" type="text" class="form-control" placeholder="Pregunta" name="pregunta" value="{{ old('pregunta') }}" autofocus onclick="limpiarError()" onkeypress="return soloLetras(event)">
                        <span class="input-group-addon"><i class="fas fa-equals"></i></span>
                    </div>
                        
                    @if ($errors->has('pregunta'))
                        <span class="message-error invalid-feedback" role="alert">
                            <strong style="color: #D22F34;">{{ $errors->first('pregunta') }}</strong>
                        </span>
                    @endif

                </div>
            </div> 

            <div class="form-group">
                <div id="respuesta-error" class="{{ $errors->has('respuesta') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <input id="respuesta" type="text" class="form-control" placeholder="Respuesta" name="respuesta" value="{{ old('respuesta') }}" autofocus onclick="limpiarError()">
                        <span class="input-group-addon"><i class="fas fa-edit"></i></span>
                    </div>
                        
                    @if ($errors->has('respuesta'))
                        <span class="message-error invalid-feedback" role="alert">
                            <strong style="color: #D22F34;">{{ $errors->first('respuesta') }}</strong>
                        </span>
                    @endif

                </div>
            </div>   

            <div class="form-group">
                <div id="email-error" class="{{ $errors->has('email') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" autofocus onclick="limpiarError()">
                        <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                    </div>
                        
                    @if ($errors->has('email'))
                        <span class="message-error invalid-feedback" role="alert">
                            <strong style="color: #D22F34;">{{ $errors->first('email') }}</strong>
                        </span>
                    @endif

                </div>
            </div>

            <div class="form-group">
                <div id="password-error" class="{{ $errors->has('password') ? 'has-error' : '' }}">
                    <div class="input-group" style="width: 100%;">
                        <input id="password" type="password" placeholder="Contraseña" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" onclick="limpiarError()">
                    </div>
                    <strong style="color: #D22F34;" class="mensaje-error-password"></strong>
                    @if ($errors->has('password'))
                        <span class="message-error invalid-feedback" role="alert">
                            <strong style="color: #D22F34;">{{ $errors->first('password') }}</strong>
                        </span>
                    @endif

                </div>
            </div>   

             <div class="form-group">
                <div id="password-confirm-error" class="{{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                    <div class="input-group" style="width: 100%;">
                        <input id="password-confirm" type="password" placeholder="Confirmar Contraseña" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" onclick="limpiarError()">
                    </div>
                     <strong style="color: #D22F34;" class="mensaje-error-password"></strong>
                    @if ($errors->has('password_confirmation'))
                        <span class="message-error invalid-feedback" role="alert">
                            <strong style="color: #D22F34;">{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif

                </div>
            </div>  

            <div class="form-group">
                <button type="submit" class="btn btn-success login-btn btn-block">Registrar <i class="far fa-thumbs-up"></i></button>
            </div>

            <div class="or-seperator"></div>
            <div class="text-center social-btn">
                <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-thumbtack"></i>&nbsp;<b>Login</b></a>
            </div>

        </form>
    </div>

@endsection

@section('js')

    <script>
        function limpiarError () {
            var array = ['email', 'password', 'nombre', 'apellido', 'pregunta', 'respuesta', 'password-confirm'];

            for (var i = 0; i < array.length; i++) {
                $("#" + array[i]  + "-error").removeClass("has-error")
            }
            $(".message-error").hide();
        }

        function sendform (event) {
            var email    = $('#email').val();
            var password = $('#password').val();

            //formato contraseña
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ -/:-@\[-`{-~]).{6,64}$/g;//match
            var formatPass = regex.exec(password)

            if(formatPass == null && password.length > 5) {
                $('.mensaje-error-password').text('Ingrese un formato de contraseña correcto.')
                return false
            } else return true
             event.preventDefault();
        }

        function soloLetras(e){
           key = e.keyCode || e.which;
           tecla = String.fromCharCode(key).toLowerCase();
           letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
           especiales = "8-37-39-46";

           tecla_especial = false
           for(var i in especiales){
                if(key == especiales[i]){
                    tecla_especial = true;
                    break;
                }
            }

            if(letras.indexOf(tecla)==-1 && !tecla_especial){
                return false;
            }
        }

        //bootstrap-show-password 
        $("#password").password({
            eyeClass: 'fa',
            eyeOpenClass: 'fa-eye',
            eyeCloseClass: 'fa-eye-slash'
        });
        $("#password-confirm").password({
            eyeClass: 'fa',
            eyeOpenClass: 'fa-eye',
            eyeCloseClass: 'fa-eye-slash'
        });
    </script>

@endsection
