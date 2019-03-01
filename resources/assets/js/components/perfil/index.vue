<template>
		<div>
			<div class="row">
	            <div class="col-xs-12">

	             	<app-title :title="title"></app-title>

					<div class="text-center">
						<div class="pretty p-default p-curve">
					        <input type="radio" name="color" v-model="radio" value="perfil" @click="changeCheck" />
					        <div class="state p-danger-o">
					            <label><b>PERFIL</b></label>
					        </div>
					    </div>
					    <div class="pretty p-default p-curve">
					        <input type="radio" name="color" v-model="radio" value="contrasena" @click="changeCheck" />
					        <div class="state p-success-o">
					            <label><b>CONTRASEÑA</b></label>
					        </div>
					    </div>
					
						<div class="pretty p-default p-curve">
					        <input type="radio" name="color" v-model="radio" value="inhabilitar" @click="changeCheck" />
					        <div class="state p-warning-o">
					            <label><b>INHABILITAR</b></label>
					        </div>
					    </div>
				    </div>
				    <br>

				   <!-- Formulario Perfil --> 
				   <div v-if="radio == 'perfil'" class="col-xs-12 col-sm-8 col-sm-offset-2">
	               <div class="panel panel-info">
	                    <div class="panel-heading">FORMULARIO</div>
	                      <div class="panel-body">
						
	                       	  <div v-if="errorUpdate" class="alert alert-warning">
	                            <strong>Se debe de especificar al menos un valor diferente.</strong> 
	                          </div>

	                          <form @submit.prevent="" autocomplete="off">
								
								<div class="col-xs-12">
	                                  <label>ROL: (*)</label>
	                                    <div class="input-group">
	                                      <span class="input-group-addon"><i class="fas fa-address-card"></i></span>
	                                      <input type="text" readonly="" class="form-control" :value="user.rol ? 'ADMINISTRADOR' : 'MODERADOR'">
	                                    </div>
	                              </div>

	                              <div class="col-xs-12">
	                                  <label>NOMBRE: (*)</label>
	                                  <div :class="[ClassNombre ? 'has-error' : '']">
	                                    <div class="input-group">
	                                      <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
	                                      <input type="text" class="form-control" maxlength="60" onpaste="return false" v-model.trim="user.nombre" @click="resetError" onkeypress="return soloLetras(event)">
	                                    </div>
	                                    <p class="help-block" v-if="errors.nombre"><strong>{{ errors.nombre[0] | formRequest }}</strong></p>
	                                  </div>
	                              </div>

	                              <div class="col-xs-12">
	                                  <label>APELLIDO: (*)</label>
	                                  <div :class="[ClassApellido ? 'has-error' : '']">
	                                    <div class="input-group">
	                                      <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
	                                      <input type="text" class="form-control" maxlength="60" onpaste="return false" v-model.trim="user.apellido" @click="resetError" onkeypress="return soloLetras(event)">
	                                    </div>
	                                    <p class="help-block" v-if="errors.apellido"><strong>{{ errors.apellido[0] | formRequest }}</strong></p>
	                                  </div>
	                              </div>

	                              <div class="col-xs-12">
	                                  <label>PREGUNTA: (*)</label>
	                                  <div :class="[ClassPregunta ? 'has-error' : '']">
	                                    <div class="input-group">
	                                      <span class="input-group-addon"><i class="fas fa-equals"></i></span>
	                                      <input type="text" class="form-control" maxlength="100" onpaste="return false" v-model.trim="user.pregunta" @click="resetError" onkeypress="return soloLetras(event)">
	                                    </div>
	                                    <p class="help-block" v-if="errors.pregunta"><strong>{{ errors.pregunta[0] | formRequest }}</strong></p>
	                                  </div>
	                              </div>

	                              <div class="col-xs-12">
	                                  <label>RESPUESTA: (*)</label>
	                                  <div :class="[ClassRespuesta ? 'has-error' : '']">
	                                    <div class="input-group">
	                                      <span class="input-group-addon"><i class="fas fa-edit"></i></span>
	                                      <input type="text" class="form-control" maxlength="100" onpaste="return false" v-model.trim="user.respuesta" @click="resetError" onkeypress="return soloLetras(event)">
	                                    </div>
	                                    <p class="help-block" v-if="errors.respuesta"><strong>{{ errors.respuesta[0] | formRequest }}</strong></p>
	                                  </div>
	                              </div>

	                              <div class="col-xs-12">
	                                  <label>EMAIL: (*)</label>
	                                  <div :class="[ClassEmail ? 'has-error' : '']">
	                                    <div class="input-group">
	                                      <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
	                                      <input type="text" class="form-control" maxlength="191" onpaste="return false" v-model.trim="user.email" @click="resetError">
	                                    </div>
	                                    <p class="help-block" v-if="errors.email"><strong>{{ errors.email[0] | formRequest }}</strong></p>
	                                  </div>
	                              </div>

	                              <div class="clearfix"></div>

	                               <div class="text-center" style="margin-top: 4%;">
	                                  <button type="submit" @click="updatePerfil" class="btn btn-success">Actualizar</button>
	                               </div>
	                                 
	                            </form>
	                          </div>
	                    </div>
	            	</div>
		            <!-- /End Formulario --> 

					<!-- Formulario Contraseña --> 
		           <div v-if="radio == 'contrasena'" class="col-xs-12 col-sm-8 col-sm-offset-2">
	               <div class="panel panel-info">
	                    <div class="panel-heading">FORMULARIO</div>
	                      <div class="panel-body">
						
	                       	  <div v-if="errorUpdate" class="alert alert-warning">
	                            <strong>Se debe de especificar al menos un valor diferente.</strong> 
	                          </div>

	                          <form @submit.prevent="changePassword" autocomplete="off">

	                               <div class="col-xs-12">
	                                  <label>PASSWORD: (*)</label>
	                                  <div :class="[ClassPassword ? 'has-error' : '']">
	                                    <div class="input-group">
	                                      <span class="input-group-addon"><i class="fas fa-eye"></i></span>
	                                      <input type="password" class="form-control" maxlength="191" onpaste="return false" v-model.trim="password" @click="resetError">
	                                    </div>
	                                    <p class="help-block" v-if="errors.password"><strong>{{ errors.password }}</strong></p>
	                                  </div>
	                              </div>

	                              <div class="col-xs-12">
	                                  <label>PASSWORD CONFIRMACION: (*)</label>
	                                  <div :class="[ClassPassword ? 'has-error' : '']">
	                                    <div class="input-group">
	                                      <span class="input-group-addon"><i class="fas fa-eye"></i></span>
	                                      <input type="password" class="form-control" maxlength="191" onpaste="return false" v-model.trim="password_confirm" @click="resetError">
	                                    </div>
	                                    <p class="help-block" v-if="errors.password"><strong>{{ errors.password }}</strong></p>
	                                  </div>
	                              </div>

	                              <div class="clearfix"></div>

	                               <div class="text-center" style="margin-top: 4%;">
	                                  <button type="submit" class="btn btn-success">Actualizar</button>
	                               </div>
	                                 
	                            </form>
	                          </div>
	                    </div>
	            	</div>
		            <!-- /End Formulario Contraseña --> 

		            <!-- Formulario inhabilitar --> 
		           <div v-if="radio == 'inhabilitar'" class="col-xs-12 col-sm-8 col-sm-offset-2">
        				<div class="text-center" style="margin-top: 4%;">
                          <button type="button" @click="userDown" class="btn btn-danger">Darse de baja <i class="far fa-thumbs-down"></i> </button>
                       </div>
	            	</div>
		            <!-- /End Formulario inhabilitar -->

				</div>
			</div>
		</div>
</template>

<script>
//Librerias
import axios from 'axios'
import toastr from 'toastr'

//Components
import Title from '../Title'
import Const from '../Const'

export default {
	mounted() {
		this.getUser()
	},
	data() {
		return {
			title: 'Perfil del Usuario',
			user: {},
			errors: {},
			errorUpdate: false,
			radio: 'perfil',
			password: '',
			password_confirm: ''
		}
	},
	filters: {
      formRequest: function (value) {
        if (!value) return ''
        value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
      }
    },
	computed: {
		ClassNombre: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.nombre != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	        }       
        },
        ClassApellido: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.apellido != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	      	}
	    },
        ClassPregunta: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.pregunta != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	      	}
	    },
        ClassRespuesta: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.respuesta != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	      	}
	    },
        ClassEmail: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.email != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	      	}
	    },
        ClassPassword: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.password != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	      	}
	    }                 
    },
	methods:{
        getUser: function () {
        var urlApiURL = Const.apiURL + '/userperfil'
          axios.get(urlApiURL).then(response => {
              this.user = response.data;
              this.user.pregunta = this.user.pregunta.slice(1,-1)
          });
	    },
	    updatePerfil: function () {
	      var urlApiURL = Const.apiURL + '/updatePerfil/' + this.user.id
          axios.put(urlApiURL, this.user).then(response => {
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.success('Perfil Actualizado Exitosamente')
            this.getUser()
          }).catch(error => {
          	if (error.response.data.code == 422) {
              return this.errorUpdate = true
            }
            this.errors = error.response.data.errors
          });
          console.clear()
	    },
	    resetError: function () {
	    	this.errorUpdate = false
	    	this.errors = {}
	    },
	    changeCheck: function () {
			this.errorUpdate = false
			this.errors = {}
			this.radio = event.target.value 
	    },
	    changePassword: function () {
	    	//formato contraseña
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[ -/:-@\[-`{-~]).{6,64}$/g;//match
            var formatPass = regex.exec(this.password)

            if (this.password.length == 0 || this.password_confirm.length == 0) {
            	this.errors = {password: 'Los campos deben de estar llenado correctamente.'}
            	return false
            } else if (this.password != this.password_confirm) {
	    		this.errors = {password: 'Las Contraseñas deben ser iguales.'}
	    		return false
	    	} else if (this.password.length < 6) {
            	this.errors = {password: 'La Contraseña debe de tener minimo 6 caracteres.'}
            	return false
            } else if (formatPass == null) {
            	this.errors = {password: 'Ingrese un formato de contraseña correcto.'}
            	return false
            }

            var urlApiURL = Const.apiURL + '/changePassword/' + this.password + '/' + this.user.id
            axios.get(urlApiURL).then(response => {
              toastr.options.positionClass = 'toast-bottom-right'
           	  toastr.success('Contraseña Actualizada Exitosamente')
           	  setInterval(function(){
                window.location.href = Const.apiURL
              },2000,"JavaScript");
          	});
	    },
	    userDown: function () {
	    	var urlApiURL = Const.apiURL + '/userDown/'+ this.user.id
            axios.get(urlApiURL).then(response => {
              toastr.options.positionClass = 'toast-bottom-right'
           	  toastr.warning('Usuario se ha dado de baja Exitosamente')
           	  setInterval(function(){
                window.location.href = Const.apiURL
              },2000,"JavaScript");
          	});
	    }
	},
	components: {
		'app-title': Title
	}
}
</script>

<style>
	
</style>