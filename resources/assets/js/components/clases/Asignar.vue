<template>
	<div>
		<div class="row">
            <div class="col-xs-12">

             <app-title :title="title"></app-title>

             <div id="top" class="text-center" style="margin-bottom: 1%;">
				<router-link to="/clases"><button class="btn btn-primary" data-toggle="tooltip" title="Regresar"><i class="fas fa-undo-alt"></i></button></router-link>
				<button class="btn btn-basic" data-toggle="tooltip" title="Reporte PDF" @click="reporte_pdf"><i class="far fa-file-pdf"></i></button>
			</div>

             <div v-if="data.clase.condicion == 'espera'">
             	
	              <!-- Filter Radio -->
	              <div class="col-xs-12 text-center">
	                  <div class="pretty p-icon p-round p-pulse">
	                      <input type="radio" name="filter" v-model="filter" value="AM" @click="" />
	                      <div class="state p-success">
	                          <i class="icon mdi mdi-check"></i>
	                          <label>ASIGNAR MIEMBROS</label>
	                      </div>
	                  </div>
	                  <div class="pretty p-icon p-round p-pulse">
	                      <input type="radio" name="filter" v-model="filter" value="CI" @click="clase_impartida=''" />
	                      <div class="state p-success">
	                          <i class="icon mdi mdi-check"></i>
	                          <label>CLASE IMPARTIDA</label>
	                      </div>
	                  </div>
	                     <div class="pretty p-icon p-round p-pulse">
	                      <input type="radio" name="filter" v-model="filter" value="E" @click="" />
	                      <div class="state p-success">
	                          <i class="icon mdi mdi-check"></i>
	                          <label>ELIMINAR</label>
	                      </div>
	                  </div>
	              </div>
	              <!-- End FIlter Radio -->

	              <div class="clearfix"></div>

	              <!-- ASIGNAR MIEMBROS --> 
	              <div v-if="filter == 'AM'">
		              <div class="col-xs-12 col-md-6">
		                    <div class="input-group">
		                      <span class="input-group-addon"><i class="fas fa-list-ul"></i></span>
		                      <select :disabled="selectGroupMiembroDisabled" class="form-control" v-model="selectMiembro.value_aux" @change="formartDato(selectMiembro.value_aux)">
		                      	   <option value="" disabled selected hidden>SELECCIONAR MIEMBROS</option> 
			                       <optgroup v-if="selectGroupMiembros.facilitadores_grupo"  label="FACILITADORES GRUPO">
									  <option v-for="facilitadores in selectGroupMiembros.facilitadores_grupo" :value="facilitadores.id+'-'+facilitadores.ocupacion">{{ facilitadores.nombre_apellido }}</option>
									</optgroup>
									 <optgroup v-if="selectGroupMiembros.auxiliares_grupo" label="AUXILIARES GRUPO">
									  <option v-for="auxiliares in selectGroupMiembros.auxiliares_grupo" :value="auxiliares.id+'-'+auxiliares.ocupacion">{{ auxiliares.nombre_apellido }}</option>
									</optgroup>
									 <optgroup v-if="selectGroupMiembros.participantes_grupo" label="PARTICIPANTES GRUPO">
									  <option v-for="participantes in selectGroupMiembros.participantes_grupo" :value="participantes.id+'-'+participantes.ocupacion">{{ participantes.nombre_apellido }}</option>
									</optgroup>
									 <optgroup v-if="selectGroupMiembros.facilitadores_externo" label="FACILITADORES Y AUXILIARES EXTERNO">
									  <option v-for="facilitadoreExterno in selectGroupMiembros.facilitadores_externo" :value="facilitadoreExterno.id+'-'+facilitadoreExterno.ocupacion">{{ facilitadoreExterno.nombre_apellido }}</option>
									</optgroup>
		                      </select>
		                    </div>
		              </div>
		               <div class="col-xs-12 col-md-3">
		                    <div class="input-group">
		                      <span class="input-group-addon"><i class="fas fa-list-ul"></i></span>
		                      <select :disabled="selectMiembroDisabled" class="form-control" v-model="selectMiembro.ocupacion">
			                   		<option value="" disabled selected hidden>OCUPACION</option> 
									<option value="F" v-if="selectOcupacion == 'F'">FACILITADOR</option>
									<option value="A" v-if="selectOcupacion == 'F'">AUXILIAR</option>
									<option value="" disabled selected hidden>OCUPACION</option>
									<option value="P" v-if="selectOcupacion == 'P'">PARTICIPANTE</option>
		                      </select>
		                    </div>
		              </div>
		              <div class="col-xs-12 col-md-3">
		              	<button type="button" class="btn btn-info" style="width: 100%;" :disabled="buttonAsignarDisabled" @click="asignarMiembroClase"><b>ASIGNAR</b> <i class="far fa-thumbs-up"></i></button>
		              </div>
	              </div>
	              <!-- ASIGNAR MIEMBROS --> 

	              <!-- Radio Si - No clase imapartida -->
	              <div class="col-xs-12 text-center" v-if="filter == 'CI'">
		              	<div class="pretty p-switch">
					        <input type="radio" name="switch1" value="SI" v-model="clase_impartida" @click="resetError" />
					        <div class="state p-success">
					            <label>SI</label>
					        </div>
					    </div>
					    <div class="pretty p-switch">
					        <input type="radio" name="switch1" value="NO" v-model="clase_impartida" @click="resetError" />
					        <div class="state p-success">
					            <label>NO</label>
					        </div>
					    </div>
	              </div>
	              <!-- End Radio Si - No clase imapartida -->

	              <!-- Eliminar -->
		              <div class="col-xs-6 col-sm-2 col-sm-offset-5" v-if="filter == 'E'">
		              	<button type="button" class="btn btn-danger" @click="deleteClase()">ELIMINAR CLASE <i class="fas fa-times"></i></button>
		              </div>
	              <!-- End Eliminar -->

             </div>
              <div class="clearfix"></div>

              <!--Clase impartida -->
              	<form v-if="clase_impartida == 'SI' && filter == 'CI'" @submit.prevent="methodofrendaClaseImpartida">
              		<div class="col-xs-12 col-sm-6 col-sm-offset-3">
	              		<div>
	                      <label>OFRENDA: (*)</label>
	                      <div :class="[ClassOfrenda ? 'has-error' : '']">
	                        <div class="input-group">
	                          <span class="input-group-addon"><i class="fas fa-money-bill-wave"></i></i></span>
	                          <input type="text" class="form-control" :disabled="!data.clase.habilitada" v-model="claseObservacionImpartida.ofrenda_aux" placeholder="1.200,00" maxlength="12" @click="resetError"  onkeypress="monto(event)" onpaste="return false">
	                        </div>
	                         <p class="help-block" v-if="errors"><strong>{{ errors.ofrenda }}</strong></p>
	                      </div>
	              		</div>
	              		<div>
                     	 <button type="submit" class="btn btn-success" :disabled="!data.clase.habilitada" style="width: 100%; margin-top: 1%;"><b>LISTO</b> <i class="far fa-thumbs-up"></i></i></button>
	              		</div>
                    </div>
              	</form>
               <!-- End Clase impartida -->

               <!--Clase NO impartida -->
               <div v-if="clase_impartida == 'NO' && filter == 'CI'">
	              	<form v-on:submit.prevent="methodclaseObservacionNoImpartida()">
	              		<div class="col-xs-12 col-sm-6 col-sm-offset-3">
		              		<div>
		                      <label>OBSERVACION: (*)</label>
		                      <div :class="[ClassObservacion ? 'has-error' : '']">
		                        <div class="input-group">
		                          <span class="input-group-addon"><i class="far fa-eye"></i></i></i></span>
		                          <textarea rows="3" class="form-control" v-model="claseObservacionNoImpartida.descripcion" maxlength="191" @click="resetError" onpaste="return false"></textarea>
		                        </div>
		                        <p class="help-block" v-if="errors"><strong>{{ errors.observacion }}</strong></p>
		                      </div>
		              		</div>
		              		<div>
	                     	 <button type="submit" class="btn btn-success" style="width: 100%; margin-top: 1%;"><b>LISTO</b> <i class="far fa-thumbs-up"></i></i></button>
		              		</div>
	                    </div>
	              	</form>
               </div>
               <!-- End Clase NO impartida -->

                <div class="clearfix"></div>

                <div v-if="data.clase.habilitada == false" class="alert alert-warning" style="margin-top: 2%;">
				  <strong>Aviso! </strong> La clase para ser impartida debe de tener minimo 1 Participante y 1 Facilitador o Auxiliar. Asigne los miembros a la clase.
				</div>

				<!-- TABLE CLASE -->
                 <div class="table-responsive" style="margin-top: 3%;">
		              <table class="table table-striped table-bordered table-hover">
		              	<thead>
		                	<tr style="background: #AEE9E2;">
		                		<th colspan="5">CLASE</th>
		                	</tr>
		              	</thead>
		              	<tbody>
		                	<tr>
		                		<th colspan="1">NOMBRE</th><td colspan="4">{{ data.clase.nombre }}</td>
		                	</tr>
		                	<tr>
		                		<th colspan="1">GRUPO</th><td colspan="4">{{ data.clase.grupo_nombre }}</td>
		                	</tr>
		                	<tr>
		                		<th colspan="1">DESCRIPCION</th><td colspan="4">{{ data.clase.descripcion }}</td>
		                	</tr>
		                	<tr>
		                		<th>FECHA</th>
		                		<th>HORA ENTRADA</th>
		                		<th>HORA SALIDA</th>
		                		<th>OFRENDA</th>
		                		<th>IMPARTIDA</th>
		                	</tr>
		                	<tr>
		                		<td>{{ formatFecha(data.clase.fecha) }}</td>
		                		<td>{{ formatDoceHora(data.clase.hora_entrada) }}</td>
		                		<td>{{ formatDoceHora(data.clase.hora_salida) }}</td>
		                		<td>{{ data.clase.ofrenda }} Bs.S</td>
		                		<td>{{ data.clase.condicion }}</td>
		                	</tr>
		                	<tr v-if="data.clase.condicion == 'no impartida'">
		                		<th colspan="5" style="background: #FF522C;">OBSERVACION</th>
		                	</tr>
		                	<tr v-if="data.clase.condicion == 'no impartida'">
		                		<td colspan="5">{{ data.clase.observacion }}</td>
		                	</tr>
		              	</tbody>
	                </table>
                </div>
                <!-- END TABLE CLASE -->

				<!-- table facilitadores y auxiliares -->
                <div class="table-responsive" style="margin-top: 3%;">
		              <table class="table table-striped table-bordered table-hover">
	                		<thead>
		                      <tr>
		                          <th colspan="5" style="background:#AEE9E2">FACILITADORES Y AUXILIARES</th>
		                      </tr>
		                      <tr>
		                      	<th>TIPO</th>
		                      	<th>CEDULA</th>
		                      	<th>NOMBRE Y APELLIDO</th>
		                      	<th>TELEFONO</th>
		                      	<th class="text-center">ACCION</th>
		                      </tr>
		                  	</thead>
		                  	<tbody>
		                  	  <tr v-if="data.facilitadores_auxiliares == ''"><td colspan="5">No se encontraron facilitadores y auxiliares registrados a esta clase.</td></tr>
		                      <tr else="" v-for="facilitador in data.facilitadores_auxiliares">
		                      	<td>{{ facilitador.tipo }}</td>
		                      	<td>{{ facilitador.cedula }}</td>
		                      	<td>{{ facilitador.nombre_apellido }}</td>
		                      	<td>{{ facilitador.telefono }}</td>
		                      	<td class="text-center">
		                      		<div v-if="showDelete != facilitador.id && showAsistencia != facilitador.id && facilitador.asistencia == 'espera'">
		                      			<button class="btn btn-info btn-xs" data-toggle="tooltip" title="Asistencia" @click="showAsistencia=facilitador.id"><i class="fas fa-child"></i></button>
		                        		<button class="btn btn-default btn-xs" data-toggle="tooltip" title="Eliminar" @click="showDelete=facilitador.id"><i class="fas fa-times"></i></button>
		                      		</div>
		                      		<div v-if="showDelete == facilitador.id">
		                      			<button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="deleteMiembro(facilitador.id)"><i class="fas fa-times"></i></button>
		                      			<button class="btn btn-default btn-xs" data-toggle="tooltip" title="Cancelar" @click="showDelete=''"><i class="fas fa-redo-alt"></i></button>
		                      		</div>
		                      		<div v-if="showAsistencia == facilitador.id">
		                      			<button class="btn btn-success btn-xs" data-toggle="tooltip" title="Asistio" @click="asistencia(facilitador.id, 'si')"><i class="far fa-thumbs-up"></i></button>
		                      			<button class="btn btn-warning btn-xs" data-toggle="tooltip" title="No Asistio" @click="asistencia(facilitador.id, 'no')"><i class="far fa-thumbs-down"></i></button>
		                      			<button class="btn btn-default btn-xs" data-toggle="tooltip" title="Cancelar" @click="showAsistencia=''"><i class="fas fa-redo-alt"></i></button>
		                      		</div>
		                      		<span v-if="facilitador.asistencia == 'si'" data-toggle="tooltip" title="ASISTIO"><i class="far fa-check-circle"></i></span>
		                      		<span v-if="facilitador.asistencia == 'no'" data-toggle="tooltip" title="NO ASISTIO"><i class="fas fa-times"></i></span>
		                      	</td>
		                      </tr>
		                  	</thead>
		                  	</tbody>
               		 </table>
                </div>
                <!-- END table facilitadores y auxiliares -->

                <!-- table participantes -->
                <div class="table-responsive" style="margin-top: 3%;">
		              <table class="table table-striped table-bordered table-hover">
	                		<thead>
		                      <tr>
		                          <th colspan="5" style="background:#AEE9E2">PARTICIPANTES</th>
		                      </tr>
		                      <tr>
		                      	<th>EDAD</th>
		                      	<th>CEDULA</th>
		                      	<th>NOMBRE Y APELLIDO</th>
		                      	<th>TELEFONO</th>
		                      	<th class="text-center">ACCION</th>
		                      </tr>
		                  	</thead>
		                  	<tbody>
		                  	  <tr v-if="data.participantes == ''"><td colspan="5">No se encontraron participantes registrados a esta clase.</td></tr>
		                      <tr v-else="" v-for="participante in data.participantes">
		                      	<td>{{ participante.tipo }}</td>
		                      	<td>{{ participante.cedula }}</td>
		                      	<td>{{ participante.nombre_apellido }}</td>
		                      	<td>{{ participante.telefono }}</td>
		                      	<td class="text-center">
		                      		<div v-if="showDelete != participante.id && showAsistencia != participante.id && participante.asistencia == 'espera'">
		                      			<button class="btn btn-info btn-xs" data-toggle="tooltip" title="Asistencia" @click="showAsistencia=participante.id"><i class="fas fa-child"></i></button>
		                        		<button class="btn btn-default btn-xs" data-toggle="tooltip" title="Eliminar" @click="showDelete=participante.id"><i class="fas fa-times"></i></button>
		                      		</div>
		                      		<div v-if="showDelete == participante.id">
		                      			<button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="deleteMiembro(participante.id)"><i class="fas fa-times"></i></button>
		                      			<button class="btn btn-default btn-xs" data-toggle="tooltip" title="Cancelar" @click="showDelete=''"><i class="fas fa-redo-alt"></i></button>
		                      		</div>
		                      		<div v-if="showAsistencia == participante.id">
		                      			<button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Asistio" @click="asistencia(participante.id, 'si')"><i class="far fa-thumbs-up"></i></button>
		                      			<button class="btn btn-warning btn-xs" data-toggle="tooltip" title="No Asistio" @click="asistencia(participante.id, 'no')"><i class="far fa-thumbs-down"></i></button>
		                      			<button class="btn btn-default btn-xs" data-toggle="tooltip" title="Cancelar" @click="showAsistencia=''"><i class="fas fa-redo-alt"></i></button>
		                      		</div>
		                      		<span v-if="participante.asistencia == 'si'" data-toggle="tooltip" title="ASISTIO"><i class="far fa-check-circle"></i></span>
		                      		<span v-if="participante.asistencia == 'no'" data-toggle="tooltip" title="NO ASISTIO"><i class="fas fa-times"></i></span>
		                      	</td>
		                      </tr>
		                  	</thead>
		                  	</tbody>
               		 </table>
                </div>
                <!-- END table participantes -->

             </div>
        </div>
	</div>
</template>

<script>
//Librerias
import axios from 'axios'
import toastr from 'toastr'

import moment from 'moment'
moment.locale('es');

//Components
import Title from '../Title'
import Const from '../Const'

export default {
	mounted() {
		this.getData()
	},
	data() {
		return {
			title: 'Detalle',
			id: this.$route.params.id,
			grupo_id: '',
			filter: 'AM',
			clase_impartida: '',
			errors: {
				'observacion' : '',
				'ofrenda': ''
			},
			clase: {
				'miembro' : '',
				'ocupacion': ''
			},
			data: {
				'clase' : {
					'condicion': ''
				}
			},
			showDelete: '',
			showAsistencia: '',
			selectGroupMiembros: {},
			selectMiembro: {
				'value_aux': '',
				'clase_id': this.$route.params.id,
				'miembro_id': '',
				'ocupacion': ''
			},
			selectOcupacion: '',
			claseObservacionNoImpartida: {
				'clase_id':this.$route.params.id,
				'descripcion': ''
			},
			claseObservacionImpartida: {
				'clase_id':this.$route.params.id,
				'ofrenda': '',
				'ofrenda_aux': ''
			}
		}
	},
	methods: {
		getData: function () {
	        var id = this.$route.params.id;
	        var urlApiURL = Const.apiURL + '/clase/' + id;
	          axios.get(urlApiURL).then(response => {
	             this.data = response.data
	             this.grupo_id = response.data.clase.grupo_id
	          	 this.getSelectGroupMiembros(this.id,this.grupo_id)
	          });
	    },
	    getSelectGroupMiembros: function (id_clase, id_grupo) {
	        var urlApiURL = Const.apiURL + '/selectGroupMiembros/' + id_clase + '/' + id_grupo
	          axios.get(urlApiURL).then(response => {
	            this.selectGroupMiembros = response.data
	          });
	    },
	    asistencia: function (id, a) {
	        var urlApiURL = Const.apiURL + '/asistenciaMiembro/' + id + '/' + a;
	          axios.get(urlApiURL).then(response => {
	          	this.showAsistencia = ''
	            this.getData()
	            this.getSelectGroupMiembros(this.id,this.grupo_id)
	            toastr.options.positionClass = 'toast-bottom-right';
	         	toastr.info('Asistencia Registrada.')
	          });
	    },
	    deleteMiembro: function (id) {
	        var urlApiURL = Const.apiURL + '/deleteMiembroClase/' + id;
	          axios.get(urlApiURL).then(response => {
	          	this.showDelete = ''
	            this.getData()
	            this.getSelectGroupMiembros(this.id,this.grupo_id)
	            toastr.options.positionClass = 'toast-bottom-right';
	         	toastr.warning('Miembro Eliminado de la Clase Exitosamente')
	          });
	    },
		resetError: function () {
        	this.errors.observacion = ''
        	this.errors.ofrenda = ''
      	},
      	formartDato: function (e) {
      		this.selectMiembro.ocupacion = ''
      		var format = e.split("-")
      		this.selectMiembro.miembro_id = format[0]
      		this.selectOcupacion = format[1]
      	},
      	asignarMiembroClase: function () {
      		var urlApiURL = Const.apiURL + '/buttonAsignarMiembroClase'
	        axios.post(urlApiURL, this.selectMiembro).then(response => {
	          this.getData()
	          this.getSelectGroupMiembros(this.id,this.grupo_id)
	          this.selectMiembro.value_aux = ''
	          this.selectOcupacion = ''
	          this.selectMiembro.ocupacion = ''
	          toastr.options.positionClass = 'toast-bottom-right';
	          toastr.success('Miembro Registrado a Clase Exitosamente')
	        });
      	},
      	deleteClase: function () {
      		var url = Const.apiURL + '/clase/' + this.id;
            axios.delete(url).then(response => {
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.warning('Clase Eliminada Exitosamente.')
                this.$router.push('/clases')
            });
      	},
      	methodclaseObservacionNoImpartida: function () {
      		var urlApiURL = Const.apiURL + '/claseObservacionNoImpartida'
	        axios.post(urlApiURL, this.claseObservacionNoImpartida).then(response => {
	          this.getData()
	          this.clase_impartida = ''
	          toastr.options.positionClass = 'toast-bottom-right';
	          toastr.success('Clase ha sido registrada como no impartida.')
	        }).catch(error => {
            	this.errors.observacion = error.response.data.errors.descripcion[0]
          	});
          	console.clear()
      	},
      	monto: function (value) {
			for (var i = 0; i < value.length; i++) {
				value = value.replace(".", "")
			}
			value = value.replace(",", ".")
			return this.claseObservacionImpartida.ofrenda = value
		},
      	methodofrendaClaseImpartida: function () {
      		var urlApiURL = Const.apiURL + '/ofrendaClaseImpartida'
      		this.monto(this.claseObservacionImpartida.ofrenda_aux)
	        axios.post(urlApiURL, this.claseObservacionImpartida).then(response => {
	          this.getData()
	          this.clase_impartida = ''
	          toastr.options.positionClass = 'toast-bottom-right';
	          toastr.success('Clase ha sido registrada como impartida.')
	        }).catch(error => {
	        	this.errors.ofrenda = error.response.data.errors.ofrenda[0]
          	});
          	console.clear()
      	},
      	formatFecha: function (f) {
      		return moment(f).format('DD/MMM/YYYY')
      	},
      	formatDoceHora: function (dh) {
      		return moment(dh, ["HH:mm"]).format("h:mm A")
      	},
      	reporte_pdf: function () {
          window.open(Const.apiURL + '/reporte-clase-individual/' + this.id, '_blank');
        }
	},
	computed: {
		selectMiembroDisabled: function () {
			if (this.selectOcupacion == '') return true
		},
		selectGroupMiembroDisabled: function () {
			if (this.selectGroupMiembros == '') return true
		},
		buttonAsignarDisabled: function () {
			if (this.selectMiembro.value_aux == '' || this.selectMiembro.ocupacion == '') return true
		},
	    ClassOfrenda: {
	        get: function () {
	          if (this.errors.ofrenda != '') return true
	        },
	        set: function () {
	          return false
	        }       
	    },
	    ClassObservacion: {
	        get: function () {
	          if (this.errors.observacion != '') return true
	        },
	        set: function () {
	          return false
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
	components: {
		'app-title': Title
	}
}
</script>

<style>
	
</style>