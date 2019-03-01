<template>
	<div>
		<div class="row">
            <div class="col-xs-12">

            <app-title :title="title"></app-title>

    			<div class="col-xs-12">
  					<!-- Search -->
  					<div class=" col-xs-12 col-sm-5 col-md-4 col-sm-offset-4 col-md-offset-6">
              			<form @submit.prevent="getClases">
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
      						<router-link to="/create-clase"><button type="button" class="btn btn-sm btn-warning" style="width: 100%;"><i class="fas fa-external-link-alt"></i> Registrar</button></router-link>
      					</div>
	                <!-- End boton Register-->
              </div>

              <br><br>

              <div class="clearfix"></div>

              <!-- Filter Radio -->
              <div class="col-xs-12 text-center">
                  <div class="pretty p-icon p-round p-pulse">
                      <input type="radio" name="filter"  value="E" v-model="filter" @click="getClases" />
                      <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>ESPERA</label>
                      </div>
                  </div>
                  <div class="pretty p-icon p-round p-pulse">
                      <input type="radio" name="filter"  value="I" v-model="filter" @click="getClases" />
                      <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>IMPARTIDA</label>
                      </div>
                  </div>
                  <div class="pretty p-icon p-round p-pulse">
                      <input type="radio" name="filter"  value="NI" v-model="filter" @click="getClases" />
                      <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>NO IMPARTIDA</label>
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
	                          <th>NOMBRE</th>
	                          <th>GRUPO</th>
	                          <th>FECHA</th>
	                          <th>HORA ENTRADA</th>
	                          <th>HORA SALIDA</th>
	                          <th>ACCION</th>
	                      </tr>
	                  </thead>
	                  <tbody>
	                      <tr v-if="clases.length == 0">
	                          <td colspan="6">No se encontraron resultados...</td>
	                      </tr>
	                      <tr v-else="" v-for="clase in clases">
	                          <td>{{ clase.nombre }}</td>
	                          <td>{{ clase.grupo }}</td>
	                          <td>{{ formatFecha(clase.fecha) }}</td>
	                          <td>{{ formatDoceHora(clase.hora_entrada) }}</td>
	                          <td>{{ formatDoceHora(clase.hora_salida) }}</td>
	                          <td class="text-center">
		                          <div v-if="filter == 'E' && showDelete != clase.id">
		                              <router-link :to="{ name: 'asignar-clase', params: { id: clase.id }}"><button class="btn btn-success btn-xs" data-toggle="tooltip" title="Asignar"><i class="fas fa-search-plus"></i></button></router-link>
		                              <router-link :to="{ name: 'editar-clase', params: { id: clase.id }}"><button class="btn btn-warning btn-xs" data-toggle="tooltip" title="Editar"><i class="fas fa-pen-square"></i></button></router-link>
		                              <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="showDelete = clase.id"><i class="fas fa-times-circle"></i></button>
                                  <button class="btn btn-basic btn-xs" data-toggle="tooltip" title="Reporte PDF" @click="reporte_pdf(clase.id)"><i class="far fa-file-pdf"></i></button>
		                          </div>
		                           <div v-if="filter == 'E' && showDelete == clase.id">
		                              <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="deleteClase(clase.id)"><i class="fas fa-times"></i></button>
		                              <button class="btn btn-default btn-xs" data-toggle="tooltip" title="Cancelar" @click="showDelete = null"><i class="fas fa-redo-alt"></i></button>
		                          </div>
		                          <div v-if="filter != 'E'">
		                              <router-link :to="{ name: 'asignar-clase', params: { id: clase.id }}"><button class="btn btn-primary btn-xs" data-toggle="tooltip" title="Detalles"><i class="fas fa-search-plus"></i></button></router-link>
		                              <button class="btn btn-basic btn-xs" data-toggle="tooltip" title="Reporte PDF" @click="reporte_pdf(clase.id)"><i class="far fa-file-pdf"></i></button>
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
		this.getClases()
	},
	data() {
		return {
			title: 'Clases',
			search: '',
			filter: 'E',
			clases: {},
			showDelete: null,
			pagination: {
	            'total'       : 0,
	            'current_page': 0,
	            'per_page'    : 0,
	            'last_page'   : 0,
	            'from'        : 0,
	            'to'          : 0
	        },
	        offset: 10
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
        }
    },
    methods: {
        getClases: function (page) {
          var radio = event.target.value
          if (radio == 'E' || radio == 'NI' || radio == 'I') this.filter = radio //asignacion cuando se da click en cada radio

          var urlClases = Const.apiURL + '/clase?filter=' + this.filter + '&page=' + page + '&search=' + this.search
          axios.get(urlClases).then(response => {
              this.clases     = response.data.clase.data
              this.pagination = response.data.pagination
          });
        },
        changePage: function (page) {
            this.pagination.current_page = page
            this.getClases(page)
        },
        vacioInputSearch: function () {
          if (this.search == '') return this.getClases()
        },
   		deleteClase: function (id) {
      		var url = Const.apiURL + '/clase/' + id;
            axios.delete(url).then(response => {
                this.getClases()
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.warning('Clase Eliminada Exitosamente.')
            });
      	},
      	formatFecha: function (f) {
      		return moment(f).format('DD/MMM/YYYY')
      	},
      	formatDoceHora: function (dh) {
      		return moment(dh, ["HH:mm"]).format("h:mm A")
      	},
        reporte_pdf: function (params) {
          window.open(Const.apiURL + '/reporte-clase-individual/' + params, '_blank');
        }
    },
	components: {
		'app-title': Title
	}
}
</script>

<style>
	
</style>