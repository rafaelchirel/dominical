<template>
	<div>
		<div class="row">
            <div class="col-xs-12">

             <app-title :title="title"></app-title>
				
			<div class="col-xs-12 col-sm-8 col-sm-offset-2">
               <div class="panel panel-info">
                    <div class="panel-heading">FORMULARIO DE REGISTRO</div>
                      <div class="panel-body">

                       	  <div v-if="errorUpdate" class="alert alert-warning">
                            <strong>Se debe de especificar al menos un valor diferente.</strong> 
                          </div>

                          <form @submit.prevent="update" autocomplete="off">

                              <div class="col-xs-12">
                                  <label>NOMBRE: (*)</label>
                                  <div :class="[ClassNombre ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fas fa-address-card"></i></span>
                                      <input type="text" class="form-control" v-model="grupo.nombre" @click="resetError" placeholder="POVULO" maxlength="100" onpaste="return false">
                                    </div>
                                     <p class="help-block" v-if="errors.nombre"><strong>{{ errors.nombre[0] | formRequest }}</strong></p>
                                  </div>
                              </div>

                              <div class="col-xs-12 col-sm-12 col-md-6">
                                  <label>EDAD INICIAL: (*)</label>
                                  <div :class="[ClassEdad_ini ? 'has-error' : '']">
                                    <div class="input-group" style="margin: 0%;">
                                      <span class="input-group-addon"><i class="fas fa-angle-double-right"></i></span>
                                      <input type="text" class="form-control" v-model="grupo.edad_ini" @click="resetError" placeholder="0" maxlength="3" onkeypress="return SoloNumeros(event)" onpaste="return false">
                                    </div>
                                     <p class="help-block" v-if="errors.edad_ini"><strong>{{ errors.edad_ini[0] | formRequest }}</strong></p>
                                  </div>
                              </div>

                              <div class="col-xs-12 col-sm-12 col-md-6">
                                  <label>EDAD FINAL: (*)</label>
                                  <div :class="[ClassEdad_fin ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fas fa-angle-double-left"></i></span>
                                      <input type="text" class="form-control" v-model="grupo.edad_fin" @click="resetError" placeholder="100" maxlength="3" onkeypress="return SoloNumeros(event)" onpaste="return false">
                                    </div>
                                     <p class="help-block" v-if="errors.edad_fin"><strong>{{ errors.edad_fin[0] | formRequest }}</strong></p>
                                  </div>
                              </div>

                               <div class="col-xs-12">
                                  <label>DESCRIPCION: (*)</label>
                                  <div :class="[ClassDescripcion ? 'has-error' : '']">
                                    <div class="input-group">
                                      <span class="input-group-addon"><i class="fab fa-accusoft"></i></span>
                                      <textarea rows="3" class="form-control" v-model="grupo.descripcion" @click="resetError" maxlength="191"  onpaste="return false"></textarea>
                                    </div>
                                     <p class="help-block" v-if="errors.descripcion"><strong>{{ errors.descripcion[0] | formRequest }}</strong></p>
                                  </div>
                              </div>

                              <div class="clearfix"></div>

                               <div class="text-center" style="margin-top: 4%;">
                                  <router-link to="/grupos"><button type="button" class="btn btn-default">Regresar</button></router-link>
                                  <button type="submit" class="btn btn-info">Actualizar</button>
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
	mounted() {
		this.getGrupo()
	},
	data() {
		return {
			title: 'Registrar',
			grupo: {},
			errorUpdate: false,
			errors: {}
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
      ClassEdad_ini: {
        get: function () {
          if (this.errors != null) {
            if (this.errors.edad_ini != undefined) return true
          }
        },
        set: function () {
          return false
        }       
      },
      ClassEdad_fin: {
        get: function () {
          if (this.errors != null) {
            if (this.errors.edad_fin != undefined) return true
          }
        },
        set: function () {
          return false
        }       
      }
  	},
	methods:{
		getGrupo: function () {
        var id = this.$route.params.id;
        var urlApiURL = Const.apiURL + '/grupo/' + id + '/edit';
          axios.get(urlApiURL).then(response => {
              this.grupo = response.data;
          });
	    },
	    update: function () {
          var url    = Const.apiURL + '/grupo/' + this.grupo.id;
          axios.put(url, this.grupo).then(response => {
            this.$router.push('/grupos')
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.success('Grupo Actualizado Exitosamente')
          }).catch(error   => {
            if (error.response.data.code == 422) {
              return this.errorUpdate = true
              console.clear()
            }
            this.errors = error.response.data.errors
            console.clear()
          });
	    },
	    resetError: function () {
	      	this.errorUpdate = false
	        this.errors = {}
	    }
	},
	components: {
		'app-title': Title
	}
}
</script>

<style>
	
</style>