@extends('layouts.app')

@section('content')

    <div class="login-form">
        <img src="{{ asset('img/banner.png') }}" width="100%;">

        <form onsubmit="return sendform(event)" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">

            @csrf

            <h2 class="text-center">Iniciar Sesion</h2>   
            
            <div class="form-group">
                <div id="email-error" class="{{ $errors->has('email') ? 'has-error' : '' }}">
                    <div class="input-group">
                        <input id="email" type="text" class="form-control" placeholder="admin@hotmail.com" name="email" value="{{ old('email') }}" autofocus onkeyup="isDisabledSubmit()">
                        <span class="input-group-addon"><i class="fas fa-user-tie"></i></span>
                    </div>
                    <strong style="color: #D22F34;" id="mensanje-error-email"></strong>
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
                        <input id="password" type="password" placeholder="Contraseña" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" onkeyup="isDisabledSubmit()">
                    </div>
                    <strong style="color: #D22F34;" id="mensanje-error-password"></strong>
                    @if ($errors->has('password'))
                        <span class="message-error invalid-feedback" role="alert">
                            <strong style="color: #D22F34;">{{ $errors->first('password') }}</strong>
                        </span>
                    @endif

                </div>
            </div>    

            <div class="form-group">
                <button type="submit" id="submit" disabled="" class="btn btn-success login-btn btn-block">Entrar <i class="far fa-thumbs-up"></i></button>
            </div>

            <div class="clearfix">
                <div class="pretty p-icon p-smooth">
                    <input type="checkbox" />
                    <div class="state p-success">
                        <i class="icon fa fa-check"></i>
                        <label> Recuérdame</label>
                    </div>
                </div>
                <a href="{{ url('resetpassword') }}" class="pull-right">Olvido contraseña?</a>
            </div>

            <div class="or-seperator"></div>
            <div class="text-center social-btn">
                <a href="{{ route('register') }}" class="btn btn-primary"><i class="fas fa-thumbtack"></i>&nbsp;<b>Registrar</b></a>
            </div>

        </form>
    </div>

@endsection

@section('js')

    <script>
        //function para validar email
       function validateEmail(email) {
          var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
        }

        function isDisabledSubmit () {
            var email    = $('#email').val();
            var password = $('#password').val();

            if (email.length == 0 || password.length < 6) $("#submit").attr("disabled", true);
            else $("#submit").attr("disabled", false);
        }

        $("#email,#password").click(function() {
            $("#email-error").removeClass("has-error")
            $("#password-error").removeClass("has-error")
            $('#mensanje-error-password').text('')
            $('#mensanje-error-email').text('')
            $(".message-error").hide();
        });

        function sendform (event) {
            //formato contraseña
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ -/:-@\[-`{-~]).{6,64}$/g;//match
            var formatPass;

            var email    = $('#email').val()
            var password = $('#password').val()

            formatPass = regex.exec(password)

            if (!validateEmail(email)){
                $('#mensanje-error-email').text('Email incorrecto.')
                return false
            } 
            else if(formatPass == null) {
                $('#mensanje-error-password').text('Formato de Contraseña Incorrecto.')
                return false
            }
            else return true;
            event.preventDefault();
        }

        //bootstrap-show-password 
        $("#password").password({
            eyeClass: 'fa',
            eyeOpenClass: 'fa-eye',
            eyeCloseClass: 'fa-eye-slash'
        });
    </script>

@endsection
