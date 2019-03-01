<template>
	<div>
		<div class="row">
            <div class="col-xs-12">

            <app-title :title="title"></app-title>

			<!-- Form -->
            <div class="col-xs-12 col-sm-8 col-sm-offset-2">
               <div class="panel panel-info">
                    <div class="panel-heading">FORMULARIO DE REGISTRO</div>
                      <div class="panel-body">
                          <form @submit.prevent="save">

                              <div class="col-xs-12">
                                  <label>NOMBRE: (*)</label>
                                  <div :class="[ClassNombre ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="far fa-address-card"></i></span>
                                      <input type="text" class="form-control" v-model="clase.nombre" @click="resetError" placeholder="La Palabra" maxlength="191" onpaste="return false">
                                    </div>
                                     <p class="help-block" v-if="errors.nombre"><strong>{{ errors.nombre[0] | formRequest }}</strong></p>
                                  </div>
                              </div>

                              <div class="col-xs-12">
                                  <label>DESCRIPCION: (*)</label>
                                  <div :class="[ClassDescripcion ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fab fa-accusoft"></i></span>
                                      <textarea rows="3" class="form-control" v-model="clase.descripcion" @click="resetError" placeholder="Orar a Dios" maxlength="191" onpaste="return false"></textarea>
                                    </div>
                                     <p class="help-block" v-if="errors.descripcion"><strong>{{ errors.descripcion[0] | formRequest }}</strong></p>
                                  </div>
                              </div>

                               <div class="col-xs-12">
                                  <label>GRUPO: (*)</label>
                                  <div :class="[ClassGrupo ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fab fa-buromobelexperte"></i></span>
                                      <select :disabled="grupoCount" class="form-control" v-model="clase.grupo_id" @click="resetError">
                                      	<option value="" disabled selected hidden>SELECCIONAR</option> 
                                      	<option v-for="grupo in grupos" :value="grupo.id">{{ grupo.nombre }}</option>
                                      </select>
                                    </div>
                                     <p class="help-block" v-if="errors.grupo"><strong>{{ errors.grupo[0] | formRequest }}</strong></p>
                                  </div>
                              </div>

                              <div class="col-xs-12">
                                  <label>TURNO FACILITADOR: (*)</label>
                                  <div :class="[ClassFacilitador ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="far fa-clock"></i></span>
                                      <select :disabled="grupoCount" class="form-control" v-model="clase.turno_facilitador" @click="resetError">
                                      	<option value="" disabled selected hidden>SELECCIONAR</option> 
                                      	<option value="M">MAÑANA</option>
                                      	<option value="T">TARDE</option>
                                      	<option value="N">NOCHE</option>
                                      </select>
                                    </div>
                                     <p class="help-block" v-if="errors.turno_facilitador"><strong>{{ errors.turno_facilitador[0] | formRequest }}</strong></p>
                                  </div>
                              </div>

                               <div class="col-xs-12">
                                  <label>FECHA | HORA ENTRADA: (*)</label>
                                  <div :class="[ClassHora_Entrada ? 'has-error' : '']">
                                    <div class="input-group" @click="resetError">
                                      <span class="input-group-addon"><i class="fas fa-history"></i></span>
                                      <datetime v-model="clase.hora_entrada" value-zone="local" zone="local" use12-hour type="datetime" placeholder="ingresar" input-class="form-control"></datetime>
                                    </div>
                                     <p class="help-block" v-if="errors.hora_entrada"><strong>{{ errors.hora_entrada[0] | formRequest }}</strong></p>
                                  </div>
                              </div>

                              <div class="col-xs-12">
                                  <label>FECHA | HORA SALIDA: (*)</label>
                                  <div :class="[ClassHora_Salida ? 'has-error' : '']">
                                    <div class="input-group" @click="resetError">
                                      <span class="input-group-addon"><i class="fas fa-history"></i></span>
                                      <datetime v-model="clase.hora_salida" value-zone="local" zone="local" use12-hour type="datetime" placeholder="ingresar" input-class="form-control"></datetime>
                                    </div>
                                     <p class="help-block" v-if="errors.hora_salida"><strong>{{ errors.hora_salida[0] | formRequest }}</strong></p>
                                  </div>
                              </div>

                              <div class="clearfix"></div>

                               <div class="text-center" style="margin-top: 4%;">
                                  <router-link to="/clases"><button type="button" class="btn btn-default">Regresar</button></router-link>
                                  <button type="reset" class="btn btn-danger" @click="resetear">Resetear</button>
                                  <button type="submit" class="btn btn-info" :disabled="grupoCount">Registrar</button>
                               </div>
                                 
                            </form>
                          </div>
                    </div>
              </div>
              <!-- End Form -->

			</div>
		</div>
	</div>
</template>

<script>
//Librerias
import axios from 'axios'
import toastr from 'toastr'

import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

//Components
import Title from '../Title'
import Const from '../Const'

export default {
	mounted() {
		this.getGrupo()
	},
	data() {
		return {
			title: 'Registrar Clase',
			clase: {
				nombre: '',
				descripcion: '',
				turno_facilitador: '',
				hora_entrada: '',
				hora_salida: '',
				grupo_id: ''
			},
			errors: {},
			grupos: {}
		}
	},
	filters: {
      formRequest: function (value) {
        if (!value) return ''
        value = value.toString()
        return value.charAt(0).toUpperCase() + value.slice(1)
      }
    },
	methods:{
		save: function () {
        var urlApiURL = Const.apiURL + '/clase'
          axios.post(urlApiURL, this.clase).then(response => {
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.success('Grupo Registrado Exitosamente')
           	this.$router.push('/asignar-clase/' + response.data)
          }).catch(error => {
            this.errors = error.response.data.errors
            console.clear()
          });
		},
		getGrupo: function () {
        	var urlApiURL = Const.apiURL + '/listGrupos'
	        axios.post(urlApiURL).then(response => {
	          this.grupos = response.data
	        });
		},
	    resetError: function () {
	      this.errors = {}
	    },
	    resetear: function(){
	      this.errors = {}
	      this.clase = {}
	      this.clase.turno_facilitador = ''
		  this.clase.grupo_id = ''
	    }
	},
	computed: {
		grupoCount: function() {
			if (this.grupos.length == 0) return true
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
	    ClassDescripcion: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.descripcion != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	        }       
	    },
	    ClassFecha: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.fecha != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	        }       
	    },
	    ClassHora_Entrada: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.hora_entrada != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	        }       
	    },
	    ClassHora_Salida: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.hora_salida != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	        }       
	    },
	    ClassGrupo: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.grupo != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	        }       
	    },
	     ClassFacilitador: {
	        get: function () {
	          if (this.errors != null) {
	            if (this.errors.turno_facilitador != undefined) return true
	          }
	        },
	        set: function () {
	          return false
	        }       
	    }
	},
	components: {
		'app-title': Title,
		datetime: Datetime
	}
}
</script>

<style>
	
</style>