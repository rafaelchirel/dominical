<template>
	<div>
		<div class="row">
            <div class="col-xs-12">

            <app-title :title="title"></app-title>

    			<div class="col-xs-12">
    					<!-- Search -->
    					<div class="col-xs-12 col-sm-5 col-md-4 col-sm-offset-5 col-md-offset-6">
                			<form @submit.prevent="getUsuarios">
          						<div class="input-group add-on">
          							<input placeholder="Buscar" type="text" class="form-control" v-model.trim="search" @keyup="vacioInputSearch">
          							<div class="input-group-btn">
          								<button type="submit" class="btn btn-default">
          									<i class="fas fa-search"></i>
          								</button>
          							</div>
          						</div>
                			</form>
    					</div>
    					<!-- End Search -->

              <!-- button Reporte -->
              <div class="col-xs-12 col-sm-2 col-md-2">
                <button type="button" class="btn btn-dark" style="width: 100%;" :disabled=buttonReportTotal @click="methodIsActivedButtonReport">Reporte <i class="fas fa-expand-arrows-alt"></i></button>
              </div>
              <!-- /End button Reporte -->
            </div>

              <br><br>

              <div class="clearfix"></div>

              <!-- Botones de reporte -->
              <div v-if="isActivedButtonReport" class="text-center col-xs-12">
                <button type="button" class="btn btn-dark" @click="reporte_pdf('todos')" :disabled=buttonReportTotal>REPORTE - TODOS <i class="fas fa-file-alt"></i></button>
                <button type="button" class="btn btn-dark" @click="reporte_pdf('administrador')" :disabled=buttonReportAdministrador>REPORTE - ADMINISTRADOR <i class="fas fa-file-alt"></i></button>
                <button type="button" class="btn btn-dark" @click="reporte_pdf('moderador')" :disabled=buttonReportModerador>REPORTE - MODERADOR <i class="fas fa-file-alt"></i></button>
              </div>
              <!-- End Botones de reporte -->

              <!-- Filter Radio -->
              <div class="col-xs-12 text-center">
                  <div class="pretty p-icon p-round p-pulse">
                      <input type="radio" name="filter"  value="T" v-model="filter" @click="getUsuarios" />
                      <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>TODOS</label>
                      </div>
                  </div>
                  <div class="pretty p-icon p-round p-pulse">
                      <input type="radio" name="filter"  value="A" v-model="filter" @click="getUsuarios" />
                      <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>ADMINISTRADOR</label>
                      </div>
                  </div>
                  <div class="pretty p-icon p-round p-pulse">
                      <input type="radio" name="filter"  value="M" v-model="filter" @click="getUsuarios" />
                      <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>MODERADOR</label>
                      </div>
                  </div>
              </div>
              <!-- End FIlter Radio -->

			  <br>

			  <div class="col-xs-12">
			  <!--   Tabla -->
	          <div class="table-responsive">
	              <table class="table table-striped table-bordered table-hover">
	                  <thead>
	                      <tr>
                              <th>ID</th>
	                          <th>NOMBRE Y APELLIDO</th>
	                          <th>EMAIL</th>
	                          <th>ROL</th>
	                          <th>HABILITADO</th>
	                          <th>ACCION</th>
	                      </tr>
	                  </thead>
	                  <tbody>
	                      <tr v-if="usuarios.length == 0">
	                          <td colspan="6">No se encontraron resultados...</td>
	                      </tr>
	                      <tr v-else="" v-for="usuario in usuarios">
	                      	  <td>{{ usuario.id }}</td>
	                          <td>{{ usuario.nombre + ' ' + usuario.apellido }}</td>
	                          <td>{{ usuario.email }}</td>
	                          <td><span :class="[usuario.rol ? 'label label-success' : 'label label-warning']">{{ usuario.rol ? 'Administrador' : 'Moderador' }}</span></td>
	                          <td><span :class="[usuario.habilitado ? 'label label-success' : 'label label-warning']">{{ usuario.habilitado ? 'SI' : 'NO'}}</span></td>
	                          	<td class="text-center">
		                           <div v-if="showDelete == usuario.id" v-bind:id="usuario.id">
		                              <button class="btn btn-danger btn-xs sd" data-toggle="tooltip" title="Eliminar" @click="deleteUsuario(usuario.id)"><i class="far fa-thumbs-down"></i></button>
		                              <button class="btn btn-default btn-xs sd" data-toggle="tooltip" title="Cancelar" @click="showDelete = null"><i class="fas fa-times-circle"></i></button>
		                          </div>
		                          <div v-else>
		                          	  <button :class="usuario.rol ? 'btn btn-primary btn-xs' : 'btn btn-default btn-xs'" data-toggle="tooltip" :title="usuario.rol ? 'Bajar a Moderador' : 'Subir a Administrador'" @click="rol(usuario.id)"><i class="fas fa-child"></i></i></button>
		                           		<button :class="usuario.habilitado ? 'btn btn-danger btn-xs' : 'btn btn-success btn-xs'" data-toggle="tooltip" :title="usuario.habilitado ? 'Inhabilitar' : 'Habilitar'" @click="habilitado(usuario.id)"><i class="fas fa-caret-up"></i></button>
	                          	   	<button class="btn btn-default btn-xs" data-toggle="tooltip" title="Restaurar Contraseña (123456)" @click="resetcontrasena(usuario.id)"><i class="fab fa-expeditedssl"></i></button>
	                          	   	<button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="showDelete = usuario.id"><i class="fas fa-times-circle"></i></button>
                                  <button class="btn btn-basic btn-xs" data-toggle="tooltip" title="Reporte PDF" @click="reporte_pdf(usuario.id)"><i class="far fa-file-pdf"></i></button>
                              </div>
	                          	</td>
	                      </tr>
	                  </tbody>
	              </table>
	          </div>
		      <!-- End  Tabla -->
			</div>

			<!-- Paginacion -->
		      <nav class="text-center">
		          <ul class="pagination">
		              <li v-if="pagination.current_page > 1">
		                  <a href="#" @click.prevent="changePage(pagination.current_page - 1)">
		                      <span>Atras</span>
		                  </a>
		              </li>
		              <li v-if="pagination.total > 10" v-for="page in pagesNumber" :class="[ page == isActived ? 'active' : '' ]">
		                  <a href="#" @click.prevent="changePage(page)">
		                      <span>{{ page }}</span>
		                  </a>
		              </li>
		              <li v-if="pagination.current_page < pagination.last_page">
		                  <a href="#" @click.prevent="changePage(pagination.current_page + 1)">
		                      <span>Siguiente</span>
		                  </a>
		              </li>
		          </ul>
		        </nav>
		    <!-- / End Paginacion -->

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
		this.getUsuarios()
    this.getConsultaButtonReporte()
	},
	data() {
		return {
			title: 'Usuarios - ACL',
			search: '',
			filter: 'T',
			usuarios: {},
			showDelete: null,
			pagination: {
	            'total'       : 0,
	            'current_page': 0,
	            'per_page'    : 0,
	            'last_page'   : 0,
	            'from'        : 0,
	            'to'          : 0
	    },
	    offset: 10,
      buttonReporte: {},
      isActivedButtonReport: false
			}
	},
	computed: {
       isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
          if(!this.pagination.to){
              return [];
          }
          var from = this.pagination.current_page - this.offset; 
          if(from < 1){
              from = 1;
          }
          var to = from + (this.offset * this.offset);
          if(to >= this.pagination.last_page){
              to = this.pagination.last_page;
          }
          var pagesArray = [];
          while(from <= to){
              pagesArray.push(from);
              from++;
          }
          return pagesArray;
        },
        buttonReportTotal: function () {
          return this.buttonReporte.todos
        },
        buttonReportAdministrador: function () {
          return this.buttonReporte.administrador
        },
        buttonReportModerador: function () {
          return this.buttonReporte.moderador
        }
    },
    methods: {
       getUsuarios: function (page) {
          var radio = event.target.value
          if (radio == 'T' || radio == 'A' || radio == 'M') this.filter = radio //asignacion cuando se da click en cada radio

          var urlUsuario = Const.apiURL + '/usuario?filter=' + this.filter + '&page=' + page + '&search=' + this.search
          axios.get(urlUsuario).then(response => {
              this.usuarios     = response.data.usuario.data
              this.pagination = response.data.pagination
          });
        },
        getConsultaButtonReporte: function () {
          var urlUsuario = Const.apiURL + '/consulta-button-reporte'
          axios.get(urlUsuario).then(response => {
              this.buttonReporte = response.data
          });
        },
        methodIsActivedButtonReport: function () {
          if (this.isActivedButtonReport) this.isActivedButtonReport = false
          else this.isActivedButtonReport = true
        },
        changePage: function (page) {
            this.pagination.current_page = page
            this.getUsuarios(page)
        },
        vacioInputSearch: function () {
          if (this.search == '') return this.getUsuarios()
        },
   		habilitado: function (id) {
          var url = Const.apiURL + '/usuario/habilitado/' + id
          axios.get(url).then(response => {
            
            toastr.options.positionClass = 'toast-bottom-right';
            
            if (response.data.sessionActual) {
              toastr.warning('Usuario No Habilitado.')
              setInterval(function(){
                window.location.href = Const.apiURL
              },2000,"JavaScript");
            } else {
              if (response.data) toastr.info('Usuario Habilitado')
              else toastr.warning('Usuario No Habilitado.')
              this.getUsuarios()
            }
            console.clear()
          });
        },
   		resetcontrasena: function (id) {
          var url = Const.apiURL + '/usuario/resetcontrasena/' + id
          axios.get(url).then(response => {
			    toastr.options.positionClass = 'toast-bottom-right'
	         toastr.info('Contraseña Restaurada por default')
             console.clear()
	         if (response.data.refresh) {
		         setInterval(function(){
				        window.location.href = Const.apiURL
				     },2000,"JavaScript");
	         }
             this.getUsuarios()
          });
        },
   		rol: function (id) {
          var url = Const.apiURL + '/usuario/rol/' + id
          axios.get(url).then(response => {
            toastr.options.positionClass = 'toast-bottom-right'
            if (response.data) toastr.info('Rol cambiado a Administrador')
            else toastr.warning('Rol cambiado a Moderador')
              if (response.data.user) {
                this.$store.state.sidebarRol = response.data.rol
                this.$router.push('/miembros')
              } else {
                this.getUsuarios()
              }
            console.clear()
          });
        },
   		deleteUsuario: function (id) {
      		var url = Const.apiURL + '/usuario/' + id
            axios.delete(url).then(response => {
                this.getUsuarios()
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.warning('Usuario Eliminada Exitosamente.')
            });
      	},
        reporte_pdf: function (params) {
          window.open(Const.apiURL + '/reporte-user/' + params, '_blank');
        }
    },
	components: {
		'app-title': Title
	}
}
</script>

<style>
	
</style>