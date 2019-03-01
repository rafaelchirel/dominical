<template>
		<div>
			<div class="row">
	            <div class="col-xs-12">

	             	<app-title :title="title"></app-title>

	             	<!-- Boton Register -->
      					<div class=" text-center">
      						<button type="button" class="btn btn-sm btn-warning" style="width: 30%;" @click="generarRespaldo"><i class="fas fa-coins"></i> Generar Respaldo</button>
      					</div>
      					<br>
	                <!-- End boton Register-->

	             	<div class="table-responsive">
	        			<table class="table table-striped table-bordered table-hover">
		             		<thead>
					            <tr>
					              <th>NOMBRE</th>
					              <th>TAMAÑO</th>
					              <th>FECHA</th>
					              <th>ACCION</th>
					            </tr>
					        </thead>
		             		<tbody>
		             			<tr v-if="respaldo.length == 0">
				                  <td colspan="5">No se ha encontrado ningun Respaldo de Seguridad.</td>
				                </tr>
			                    <tr v-else="" v-for="r in respaldo">
			                      <td>{{ r.file_name }}</td>
			                      <td>{{ r.file_size }}</td>
			                      <td>{{ r.last_modified }}</td>
			                      <td class="text-center">
			                            <button type="button" @click="download(r.file_name)" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Descagar"><i class="fas fa-download"></i> Descargar</button>
			                            <button type="button" @click="deleteRespaldo(r.file_name)" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="ELiminar"><i class="fas fa-times"></i> Eliminar</button>
			                      </td>
			                    </tr>
				              </tbody>
		             	</table>
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

export default {
	mounted() {
		this.getRespaldo()
	},
	data() {
		return {
			title: 'Respaldo de DB',
	        respaldo: ''
		}
	},
	computed: {
		//
    },
	methods:{
        getRespaldo: function () {
          var url = Const.apiURL + '/respaldo-database'
          axios.get(url).then(response => {
              this.respaldo     = response.data
          });
        },
        generarRespaldo: function () {
          var url = Const.apiURL + '/backup/create'
          axios.get(url).then(response => {
              this.getRespaldo()
              toastr.options.positionClass = 'toast-bottom-right';
              toastr.success('Respaldo Generado Exitosamente.')
          });
        },
        download: function (file) {
          var url = Const.apiURL + '/backup/download/' + file
          window.open(url, '_blank');
          toastr.options.positionClass = 'toast-bottom-right';
          toastr.info('Respaldo Descargado Exitosamente.')
        },
        deleteRespaldo: function (file) {
          var url = Const.apiURL + '/backup/delete/' + file
          axios.get(url).then(response => {
              this.getRespaldo()
              toastr.options.positionClass = 'toast-bottom-right';
              toastr.warning('Respaldo Eliminado Exitosamente.')
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