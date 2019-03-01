<template>
	<div>
		<div class="row">
        <div class="col-xs-12">

            <app-title :title="title"></app-title>
				
            <div class="col-sm-10 col-xs-12 col-sm-offset-1">
               <div class="panel panel-info">
                    <div class="panel-heading">FORMULARIO DE REGISTRO</div>
                      <div class="panel-body">
                          <form @submit.prevent="save" autocomplete="off">
                            
                              <div class="col-xs-12 col-md-5 col-md-offset-1">
                                  <label>CEDULA: (*)</label>
                                  <div :class="[ClassCedula ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fas fa-id-card"></i></span>
                                      <input type="text" class="form-control" v-model="miembro.cedula" placeholder="V-26745896" maxlength="13" @click="resetError" onpaste="return false">
                                    </div>
                                     <p class="help-block" v-if="errors.cedula"><strong>{{ errors.cedula[0] | formRequest }}</strong></p>
                                  </div>
                              </div>

                              <div class="col-xs-12 col-md-5">
                                <label>NOMBRE: (*)</label>
                                <div :class="[ClassNombre ? 'has-error' : '']">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user-check"></i></span>
                                    <input type="text" class="form-control" v-model="miembro.nombre" placeholder="John" maxlength="100" @click="resetError" onkeypress="return soloLetras(event)" onpaste="return false">
                                  </div>
                                 <p class="help-block" v-if="errors.nombre"><strong>{{ errors.nombre[0] | formRequest }}</strong></p>
                                </div>
                              </div>

                               <div class="clearfix"></div>

                              <div class="col-xs-12 col-md-5 col-md-offset-1">
                                <label>APELLIDO: (*)</label>
                                <div :class="[ClassApellido ? 'has-error' : '']">
                                  <div class="input-group">
                                    <span class="input-group-addon"><i class="fas fa-user-check"></i></span>
                                    <input type="text" class="form-control" v-model="miembro.apellido" placeholder="Doe" maxlength="100" @click="resetError" onkeypress="return soloLetras(event)" onpaste="return false">
                                  </div>
                                  <p class="help-block" v-if="errors.apellido"><strong>{{ errors.apellido[0] | formRequest }}</strong></p>
                                </div>
                              </div>

                              <div class="col-xs-12 col-md-5">
                                <label>GENERO: (*)</label>
                                <div :class="[ClassGenero ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fas fa-arrow-alt-circle-up"></i></span>
                                      <select class="form-control" v-model="miembro.genero" @click="resetError">
                                        <option value="F">FEMENINO</option>
                                        <option value="M">MASCULINO</option>
                                      </select>
                                    </div>
                                    <p class="help-block" v-if="errors.genero"><strong>{{ errors.genero[0] | formRequest }}</strong></p>
                                </div>
                              </div>

                              <div class="clearfix"></div>

                              <div class="col-xs-12 col-md-5 col-md-offset-1">
                                <label>FECHA DE NACIMIENTO: (*)</label>
                                <div :class="[ClassFecha_nac ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fas fa-calendar-check"></i></span>
                                      <input type="date" class="form-control" v-model="miembro.fecha_nac" @click="resetError">
                                    </div>
                                    <p class="help-block" v-if="errors.fecha_nac"><strong>{{ errors.fecha_nac[0] | formRequest }}</strong></p>
                                </div>
                              </div>

                              <div class="col-xs-12 col-md-5">
                                <label>CORREO ELECTRONICO:</label>
                                <div :class="[ClassEmail ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fas fa-envelope"></i></span>
                                      <input type="text" class="form-control" v-model="miembro.email" placeholder="johndoe@gmail.com" maxlength="191" @click="resetError" onpaste="return false">
                                    </div>
                                    <p class="help-block" v-if="errors.email"><strong>{{ errors.email[0] | formRequest }}</strong></p>
                                </div>
                              </div>

                              <div class="clearfix"></div>

                              <div class="col-xs-12 col-md-5 col-md-offset-1">
                                <label>TELEFONO: (*)</label>
                                <div :class="[ClassTelefono ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fas fa-address-book"></i></span>
                                      <input type="text" class="form-control" v-model="miembro.telefono" placeholder="04142474565" maxlength="11" @click="resetError" onkeypress="return SoloNumeros(event)" onpaste="return false">
                                    </div>
                                    <p class="help-block" v-if="errors.telefono"><strong>{{ errors.telefono[0] | formRequest }}</strong></p>
                                </div>
                              </div>

                              <div class="col-xs-12 col-md-5">
                                <label>DIRECCION: (*)</label>
                                <div :class="[ClassDireccion ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fas fa-warehouse"></i></span>
                                      <input type="text" class="form-control" v-model="miembro.direccion" placeholder="Urbanizacion el Parquete Calle 3 Casa Nro.3" maxlength="191" @click="resetError" onpaste="return false">
                                    </div>
                                    <p class="help-block" v-if="errors.direccion"><strong>{{ errors.direccion[0] | formRequest }}</strong></p>
                                </div>
                              </div>

                              <div class="clearfix"></div>

                              <div class="col-xs-12 col-md-5 col-md-offset-1">
                                <label>TIPO: (*)</label>
                                <div :class="[ClassTipo ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fas fa-list-ul"></i></span>
                                      <select class="form-control" v-model="miembro.tipo" @click="resetError">
                                        <option value="P">PARTICIPANTE</option>
                                        <option value="F">FACILITADOR</option>
                                        <option value="FP">PARTICIPANTE Y FACILITADOR</option>
                                      </select>
                                    </div>
                                    <p class="help-block" v-if="errors.tipo"><strong>{{ errors.tipo[0] | formRequest }}</strong></p>
                                </div>
                              </div>

                              <div class="col-xs-12 col-md-5">
                                <label>CONDICION: (*)</label>
                                <div :class="[ClassCondicion ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fas fa-list-ul"></i></span>
                                      <select class="form-control" v-model="miembro.condicion" @click="resetError" @change="observacion">
                                       <option value="invitado">INVITADO</option>
                                        <option value="activo">MIEMBRO ACTIVO</option>
                                        <option value="inactivo">MIEMBRO INACTIVO</option>
                                      </select>
                                    </div>
                                    <p class="help-block" v-if="errors.condicion"><strong>{{ errors.condicion[0] | formRequest }}</strong></p>
                                </div>
                              </div>
                              
                              <div class="clearfix"></div>

                              <div class="col-xs-12 col-md-10 col-md-offset-1" v-if="showObservacion">
                                <label>OBSERVACION - INACTIVO:</label>
                                <div :class="[ClassTipo ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fas fa-address-book"></i></span>
                                      <textarea class="form-control" v-model="miembro.descripcion" @click="resetError"></textarea>
                                    </div>
                                    <p class="help-block" v-if="errors.tipo"><strong>{{ errors.tipo[0] | formRequest }}</strong></p>
                                </div>
                              </div>

                              <div class="clearfix"  v-if="showObservacion"></div>

                               <div class="text-center" style="margin-top: 4%;">
                                  <router-link to="/miembros"><button type="button" class="btn btn-default">Regresar</button></router-link>
                                  <button type="reset" class="btn btn-danger" @click="resetear">Resetear</button>
                                  <button type="submit" class="btn btn-info">Registrar</button>
                               </div>
                                 
                            </form>
                          </div>
                    </div>
              </div>
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

	export default{
		data() {
			return{
				title: 'Miembro',
        miembro:{
          cedula:    '',
          nombre:    '',
          apellido:  '',
          genero:    'F',
          fecha_nac: '',
          email:     '',
          telefono:  '',
          direccion: '',
          tipo:      'P',
          condicion: 'invitado',
          descripcion: ''
        },
        showObservacion: false,
        errors: {}
			}
		},
    methods:{
      save: function () {
        var urlApiURL = Const.apiURL + '/miembro'
          axios.post(urlApiURL, this.miembro).then(response => {
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.success('Participante Registrado Exitosamente')
            this.$router.push('/miembros')
          }).catch(error => {
            this.errors = error.response.data.errors
          });
      },
      resetError: function () {
        this.errors = {}
      },
      resetear: function(){
          this.errors = {};
          this.miembro.cedula    = '';
          this.miembro.nombre    = '';
          this.miembro.apellido  = '';
          this.miembro.genero    = 'F';
          this.miembro.fecha_nac = '';
          this.miembro.email     = '';
          this.miembro.telefono  = '';
          this.miembro.direccion = '';
          this.miembro.tipo      = 'P';
          this.miembro.condicion = 'invitado'
      },
      observacion: function (event){
        if (event.target.value == 'inactivo'){
          this.showObservacion = true
        }else{
          this.showObservacion = false
          this.miembro.descripcion = ''
        }
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
      ClassCedula: {
        get: function () {
          if (this.errors != null) {
            if (this.errors.cedula != undefined) return true
          }
        },
        set: function () {
          return false
        }       
      },
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
      ClassGenero: {
        get: function () {
          if (this.errors != null) {
            if (this.errors.genero != undefined) return true
          }
        },
        set: function () {
          return false
        }       
      },
      ClassFecha_nac: {
        get: function () {
          if (this.errors != null) {
            if (this.errors.fecha_nac != undefined) return true
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
      ClassTelefono: {
        get: function () {
          if (this.errors != null) {
            if (this.errors.telefono != undefined) return true
          }
        },
        set: function () {
          return false
        }       
      },
      ClassDireccion: {
        get: function () {
          if (this.errors != null) {
            if (this.errors.direccion != undefined) return true
          }
        },
        set: function () {
          return false
        }       
      },
      ClassTipo: {
        get: function () {
          if (this.errors != null) {
            if (this.errors.tipo != undefined) return true
          }
        },
        set: function () {
          return false
        }       
      },
      ClassCondicion: {
        get: function () {
          if (this.errors != null) {
            if (this.errors.condicion != undefined) return true
          }
        },
        set: function () {
          return false
        }       
      }
    },
		components: {
			'app-title': Title
		}
	}
</script>

<style>
	
</style>