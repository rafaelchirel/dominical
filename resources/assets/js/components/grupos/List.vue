<template>
		<div>
		<div class="row">
            <div class="col-xs-12">

             <app-title :title="title"></app-title>

    			<div class="col-xs-12">
      					<!-- Search -->
      					<div class=" col-xs-12 col-sm-5 col-md-4 col-sm-offset-2 col-md-offset-4">
                  			<form @submit.prevent="getGrupos">
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

                <!-- Boton Register -->
				<div class="col-xs-12 col-sm-3 col-md-2">
					<router-link to="/create-grupo"><button type="button" class="btn btn-sm btn-warning" style="width: 100%;"><i class="fas fa-external-link-alt"></i> Registrar</button></router-link>
				</div>
                <!-- End boton Register-->


              <!-- button Reporte -->
              <div class="col-xs-12 col-sm-2 col-md-2">
                <button type="button" data-toggle="tooltip" title="Listado de todos los grupos" class="btn btn-sm btn btn-dark" style="width: 100%;" :disabled=buttonReportTotal @click="methodIsActivedButtonReport">Reporte <i class="fas fa-expand-arrows-alt"></i></button>
              </div>
              <!-- /End button Reporte -->

              </div>
              <br><br>

              <div class="clearfix"></div>

              <!-- Botones de reporte -->
              <div v-if="isActivedButtonReport" class="text-center col-xs-12">
                <button type="button" class="btn btn-dark" @click="reporte_pdf('lisTodosNormail')">REPORTE - TODOS <i class="fas fa-file-alt"></i></button>
                <button type="button" class="btn btn-dark" @click="reporte_pdf('lisTodosDetallado')">REPORTE - TODOS - DETALLADO <i class="fas fa-file-alt"></i></button>
              </div>
              <!-- End Botones de reporte -->

			<div class="col-xs-12">
			   <!--   Tabla -->
		          <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover">
		                  <thead>
		                      <tr>
		                          <th>NOMBRE</th>
		                          <th>DESCRIPCION</th>
		                          <th>EDAD INICIAL</th>
		                          <th>EDAD FINAL</th>
		                          <th>ACCION</th>
		                      </tr>
		                  </thead>
		                  <tbody>
		                  		<tr v-if="grupos == ''"><td colspan="5">No se encontraron Resultados...</td></tr>
			                    <tr else="" v-for="grupo in grupos">
		                          <td>{{ grupo.nombre }}</td>
		                          <td>{{ grupo.descripcion }}</td>
		                          <td>{{ grupo.edad_ini }}</td>
		                          <td>{{ grupo.edad_fin }}</td>
		                          <td class="text-center">
										<div v-if="showDelete != grupo.id">
			                              <router-link :to="{ name: 'detalle-grupo', params: { id:grupo.id }}"><button class="btn btn-primary btn-xs" data-toggle="tooltip" title="Detalles"><i class="fas fa-search-plus"></i></button></router-link>
			                              <router-link :to="{ name: 'editar-grupo', params: { id: grupo.id }}"><button class="btn btn-warning btn-xs" data-toggle="tooltip" title="Editar"><i class="fas fa-pen-square"></i></button></router-link>
			                              <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="showDelete=grupo.id"><i class="fas fa-times-circle"></i></button>
			                          	  <button class="btn btn-basic btn-xs" data-toggle="tooltip" title="Reporte PDF" @click="reporte_pdf(grupo.id)"><i class="far fa-file-pdf"></i></button>
			                          	</div>
			                          	<div v-else>
				                           <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="deleteMiembro(grupo.id)"><i class="fas fa-times"></i></button>
				                           <button class="btn btn-default btn-xs" data-toggle="tooltip" title="Cancelar" @click="showDelete=null"><i class="fas fa-redo-alt"></i></button>
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

//Components
import Title from '../Title'
import Const from '../Const'

export default {
	mounted() {
		this.getGrupos()
	},
	data() {
		return {
			title: 'Grupos',
			grupos: {},
			pagination: {},
			offset: 10,
			search: '',
			showDelete: null,
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
          if (this.grupos.length == 0) return true
          else return false
        }
    },
	methods:{
		 getGrupos: function (page) {
          var urlGrupos = Const.apiURL + '/grupo?search=' + this.search + '&page=' + page
          axios.get(urlGrupos).then(response => {
              this.grupos     = response.data.grupos.data
              this.pagination = response.data.pagination
          });
        },
        deleteMiembro: function (id) {
        	var url = Const.apiURL + '/grupo/' + id;
            axios.delete(url).then(response => {
                this.getGrupos();
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.warning('Grupo Eliminado Exitosamente.')
            }).catch(error => {
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.info(error.response.data.error)
                this.showDelete = null
                console.clear()
            });
        },
        vacioInputSearch: function () {
          if (this.search == '') return this.getGrupos()
        },
    	changePage: function (page) {
            this.pagination.current_page = page
            this.getGrupos(page)
        },
        reporte_pdf: function (params) {
          window.open(Const.apiURL + '/reporte-grupo/' + params, '_blank');
        },
        methodIsActivedButtonReport: function () {
          if (this.isActivedButtonReport) this.isActivedButtonReport = false
          else this.isActivedButtonReport = true
        },
	},
	components: {
		'app-title': Title
	}
}
</script>

<style>
	
</style>