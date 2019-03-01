@extends('layouts.app')

@section('content')

    <div class="login-form">
        <img src="{{ asset('img/banner.png') }}" width="100%;">

		<!-- Formulario CheckEmail-->
	        <form id="checkEmail" method="POST">
	            @csrf
	            <h2 class="text-center">Recuperar Contraseña</h2> 

				<h5 class="text-center"><b>PASO</b> <span class="label label-danger"><b class="paso">1</b>/3</span></h5>

	            <div class="form-group">
	                <div id="chekEmail-email-error" class="">
	                    <div class="input-group">
	                        <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
	                        <input id="email" type="email" class="form-control" placeholder="admin@hotmail.com" name="email" value="{{ old('email') }}" autofocus onkeyup="isDisabledSubmit()">
	                    </div>
	                    <span class="invalid-feedback" role="alert">
	                        <strong id="chekEmail-message-error" style="color: #D22F34;"></strong>
	                    </span>
	                </div>
	            </div>

	            <div class="form-group">
	                <button type="submit" id="submit" disabled="" class="btn btn-success login-btn btn-block">Consultar Email en Base de Datos. <i class="far fa-thumbs-up"></i></button>
	            </div>

	            <div class="or-seperator"></div>
	            <div class="text-center social-btn">
	                <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-thumbtack"></i>&nbsp;<b>Login</b></a>
	            </div>
	        </form>
	       <!-- /End CheckEMail-->


		<!-- Formulario Question-->
	          <form id="question" method="POST">
	            @csrf
	            <h2 class="text-center">Recuperar Contraseña</h2>   
				<h5 class="text-center"><b>PASO</b> <span class="label label-danger"><b class="paso">1</b>/3</span></h5>
	            <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fas fa-equals"></i></span>
                        <input readonly="" id="pregunta" type="text" class="form-control" name="pregunta" value="" autofocus>
                    </div>
	            </div>

	            <div class="form-group">
	                <div id="answer-error" class="">
	                    <div class="input-group">
	                        <span class="input-group-addon"><i class="fas fa-edit"></i></span>
	                        <input id="respuesta" type="text" class="form-control" placeholder="respuesta" name="respuesta" value="" autofocus>
	                    </div>
	                    <span class="invalid-feedback" role="alert">
	                        <strong id="answer-message-error" style="color: #D22F34;"></strong>
	                    </span>
	                </div>
	            </div>

	            <div class="form-group">
	                <button type="submit" id="button-answer" disabled="" class="btn btn-success login-btn btn-block">Verificar Respuesta.<i class="far fa-thumbs-up"></i></button>
	            </div>

	            <div class="or-seperator"></div>
	            <div class="text-center social-btn">
	                <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-thumbtack"></i>&nbsp;<b>Login</b></a>
	            </div>
	        </form>
		<!-- End Formulario Question-->

		<!-- Formulario password-->
	          <form id="password" method="POST">
	            @csrf
	            <h2 class="text-center">Recuperar Contraseña</h2>   
				<h5 class="text-center"><b>PASO</b> <span class="label label-danger"><b class="paso">1</b>/3</span></h5>
 				<strong id="password-msg-error" style="color: #D22F34;"></strong>
				
				<input type="hidden" id="id-user" name="id" value="">
	            <div class="form-group">
	                <div class="password-error">
	                    <div class="input-group" style="width: 100%;">
	                        <input id="password-input" type="password" placeholder="Contraseña" class="form-control password-input" name="password" minlength="6" maxlength="255">
	                    </div>
	                </div>
            	</div>  

            	 <div class="form-group">
	                <div class="password-error">
	                    <div class="input-group" style="width: 100%;">
	                        <input id="confirm-password-input" type="password" placeholder="Confirmar Contraseña" class="form-control password-input" name="confirm-password" minlength="6" maxlength="255">
	                    </div>
	                </div>
            	</div>  

	            <div class="form-group">
	                <button type="submit" id="procesar" disabled="" class="btn btn-success login-btn btn-block">Procesar.<i class="far fa-thumbs-up"></i></button>
	            </div>

	            <div class="or-seperator"></div>
	            <div class="text-center social-btn">
	                <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-thumbtack"></i>&nbsp;<b>Login</b></a>
	            </div>
	        </form>
		<!-- End Formulario password-->



    </div>

@endsection

@section('js')

    <script>
    	//inicilizando
    	toastr.options.positionClass = 'toast-bottom-right';
		$('#question').hide();
		$('#password').hide();

		//Variabl GLobal
		var respuesta = ''
		var id = ''
		var paso = 1

		//Limpiando Errores
			$('#email').click(function(e){
				$('#chekEmail-email-error').removeClass('has-error')
				$('#chekEmail-message-error').text('')
				$('#email').val('')
				isDisabledSubmit()
			})
	
       function validateEmail(email) {
          var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
        }

        function isDisabledSubmit () {
            var email    = $('#email').val();
            if (email.length == 0 || !validateEmail(email)) $("#submit").attr("disabled", true);
            else $("#submit").attr("disabled", false);
        }

        //Consultar Email en Base de datos - form Nro.1 - ajax
	    $("#checkEmail").submit(function (e) {
	        var data = new FormData(this);
	        var token = $("input[name=_token]").val();
	        var route = "{{ url('checkEmail') }}";
	            $.ajax({
	                url: route,
	                headers: {'X-CSRF-TOKEN': token},
	                type: 'post',
	                datatype: 'json',
	                data: data,
	                processData: false, //Evitamos que JQuery procese los datos, daría error
	                contentType: false, //No especificamos ningún tipo de dato
	                success: function (data) {
	         			toastr.success('Correo Electronico encontrado.')
	                    $('#checkEmail').hide()
	                    $('#question').fadeIn()
	                    $('#pregunta').val(data.pregunta)
	                    respuesta = data.respuesta
	                    $('#id-user').val(data.id)
	                    $('.paso').text(2)
	                },
	                error: function (data) {
	                	$('#chekEmail-email-error').addClass('has-error')
	                	$('#chekEmail-message-error').text('Email no encontrado en nuestra base de datos.')
	                },
	            });
	       e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
	    });

	    //verificando respuesta
	    $('#respuesta').keyup(function(){
	    	var respuesta_input = $('#respuesta').val()
	    	if (respuesta_input.length > 0) $("#button-answer").attr("disabled", false);
            else $("#button-answer").attr("disabled", true);
	    });

	    $('#button-answer').click(function(e){
	    	e.preventDefault();
		    if (respuesta == $('#respuesta').val()) {
		    	$('#question').hide()
	            $('#password').fadeIn()
		    	toastr.success('Respuesta Correcta. Proceda a Cambiar la Contraseña')
		    	$('.paso').text(3)
		    }
		    else toastr.warning('Respuesta Incorrecta.Vuelva a intentar')
	    });

	    //Contraseña ultimo formulario
	    $('#password-input,#confirm-password-input').keyup(function(){
	    	var pass = $('#password-input').val()
	    	var pass_conf = $('#confirm-password-input').val()
	    	if (pass.length > 0 && pass_conf.length > 0) $("#procesar").attr("disabled", false);
            else $("#procesar").attr("disabled", true);
	    })

	    $('#procesar').click(function(){
	    	var pass = $('#password-input').val()
	    	var pass_conf = $('#confirm-password-input').val()
	    	if (pass != pass_conf) $('#password-msg-error').text('Contraseñas no coinciden.')
	    	if (pass.length < 6 || pass_conf.length < 6) $('#password-msg-error').text('Longitud minima de 6 caracteres.')
	    	//formato contraseña
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ -/:-@\[-`{-~]).{6,64}$/g;//match
            var formatPass = regex.exec(pass)

            if(formatPass == null) {
                $('#password-msg-error').text('Ingrese un formato de contraseña correcto.')
                return false
            }
	    })

	    //actualizando contraseña - form Nro.3 - ajax
	    $("#password").submit(function (e) {
	        var data = new FormData(this);
	        var token = $("input[name=_token]").val();
	        var route = "{{ url('updatePassword') }}";
	            $.ajax({
	                url: route,
	                headers: {'X-CSRF-TOKEN': token},
	                type: 'post',
	                datatype: 'json',
	                data: data,
	                processData: false, //Evitamos que JQuery procese los datos, daría error
	                contentType: false, //No especificamos ningún tipo de dato
	                success: function (data) {
	         			toastr.success('Contraseña Actualizada.')
	         			$('#password-input').prop("readonly",true);
	         			$('#confirm-password-input').prop("readonly",true);
	         			$("#procesar").attr("disabled", true)
	         			setInterval(function(){
			              document.location.href = "{{ url('/') }}";
			            },2000,"JavaScript");
	                },
	                error: function (data) {
	                	//
	                },
	            });
	       e.preventDefault(); //Evitamos que se mande del formulario de forma convencional
	    });

		//bootstrap-show-password 
        $(".password-input").password({
            eyeClass: 'fa',
            eyeOpenClass: 'fa-eye',
            eyeCloseClass: 'fa-eye-slash'
        });


    </script>

@endsection

