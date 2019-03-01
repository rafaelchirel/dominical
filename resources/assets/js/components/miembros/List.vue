<template>
	<div>
		<div class="row">
            <div class="col-xs-12">

             <app-title :title="title"></app-title>

    				<div class="col-xs-12">
      					<!-- Search -->
      					<div class=" col-xs-12 col-sm-5 col-md-4 col-sm-offset-2 col-md-offset-4">
                  <form @submit.prevent="getMiembros">
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
      						<router-link to="/create-miembro"><button type="button" class="btn btn-sm btn-warning" style="width: 100%;"><i class="fas fa-external-link-alt"></i> Registrar</button></router-link>
      					</div>
                <!-- End boton Register-->


              <!-- button Reporte -->
              <div class="col-xs-12 col-sm-2 col-md-2">
                <button type="button" class="btn btn-sm btn-dark" style="width: 100%;" :disabled=buttonReportTotal @click="methodIsActivedButtonReport">Reporte <i class="fas fa-expand-arrows-alt"></i></button>
              </div>
              <!-- /End button Reporte -->


              </div>

              <br><br>
              <div class="clearfix"></div>

              <!-- Botones de reporte -->
              <div v-if="isActivedButtonReport" class="text-center col-xs-12">
                <button type="button" class="btn btn-sm btn-dark" :disabled=!isDisabledButtonRepor.todos @click="reporte('todos')">TODOS <i class="fas fa-file-alt"></i></button>
                <button type="button" class="btn btn-sm btn-dark" :disabled=!isDisabledButtonRepor.participantes @click="reporte('participantes')">PARTICIPANTES <i class="fas fa-file-alt"></i></button>
                <button type="button" class="btn btn-sm btn-dark" :disabled=!isDisabledButtonRepor.facilitadores @click="reporte('facilitadores')">FACILITADOR <i class="fas fa-file-alt"></i></button>
                <button type="button" class="btn btn-sm btn-dark" :disabled="!isDisabledButtonRepor.fac_part" @click="reporte('fac_part')">PARTICIPANTE Y FACILITADOR <i class="fas fa-file-alt"></i></button>
              <br><br>
              </div>
              <!-- End Botones de reporte -->

              <!-- Filter Radio -->
              <div v-if="!isActivedButtonReport" class="col-xs-12 text-center">
                  <div class="pretty p-icon p-round p-pulse">
                      <input type="radio" name="filter" v-model="filter" value="T" @click="getMiembros" />
                      <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>TODOS</label>
                      </div>
                  </div>
                  <div class="pretty p-icon p-round p-pulse">
                      <input type="radio" name="filter" v-model="filter" value="P" @click="getMiembros" />
                      <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>PARTICIPANTE</label>
                      </div>
                  </div>
                  <div class="pretty p-icon p-round p-pulse">
                      <input type="radio" name="filter" v-model="filter" value="F" @click="getMiembros" />
                      <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>FACILITADOR</label>
                      </div>
                  </div>
                  <div class="pretty p-icon p-round p-pulse">
                      <input type="radio" name="filter"  v-model="filter" value="FP" @click="getMiembros" />
                      <div class="state p-success">
                          <i class="icon mdi mdi-check"></i>
                          <label>PARTICIPANTE Y FACILITADOR</label>
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
                          <th>CEDULA</th>
                          <th>NOMBRES Y APELLIDOS</th>
                          <th>SEXO</th>
                          <th>EDAD</th>
                          <th>TIPO</th>
                          <th>CONDICION</th>
                          <th>ACCION</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr  v-if="miembros == undefined || miembros.length == 0">
                          <td colspan="7">No se encontraron resultados...</td>
                      </tr>
                      <tr v-else v-for="miembro in miembros">
                          <td>{{ miembro.cedula }}</td>
                          <td>{{ miembro.nombre + ' ' + miembro.apellido }}</td>
                          <td>{{ miembro.genero }}</td>
                          <td>{{ age(miembro.fecha_nac) }}</td>
                          <td>{{ tipoForm(miembro.tipo) }}</td>
                          <td>{{ miembro.condicion }}</td>
                          <td class="text-center">
                          <div v-if="showDelete != miembro.id">
                              <router-link :to="{ name: 'detalle-miembro', params: { id: miembro.id }}"><button class="btn btn-primary btn-xs" data-toggle="tooltip" title="Detalles"><i class="fas fa-search-plus"></i></button></router-link>
                              <router-link :to="{ name: 'editar-miembro', params: { id: miembro.id }}"><button class="btn btn-warning btn-xs" data-toggle="tooltip" title="Editar"><i class="fas fa-pen-square"></i></button></router-link>
                              <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="showDelete=miembro.id" v-if="miembro.condicion != 'inactivo'"><i class="fas fa-times-circle"></i></button>
                              <button class="btn btn-basic btn-xs" data-toggle="tooltip" title="PDF" @click="reporte(miembro.id)"><i class="far fa-file-pdf"></i></button>
                          </div>
                          <div v-else>
                              <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="deleteMiembro(miembro.id)"><i class="fas fa-times"></i></button>
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

  import moment from 'moment'
  moment.locale('es');

	//Components
	import Title from '../Title'
	import Const from '../Const'

	export default{
    mounted() {
      if (this.filter == undefined) this.filter = 'T'//incializando
      this.getMiembros()
      this.methodisDisabledButtonRepor()
    },
		data() {
			return{
				title: 'Listado de Miembros',
        miembros: [],
        filter: 'T',
        search: '',
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
        isActivedButtonReport: false,
        isDisabledButtonRepor: {}
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
          if (this.miembros.length == 0) return true
          else return false
        }
    },
    methods: {
        getMiembros: function (page) {
          var radio = event.target.value
          if (radio == 'T' || radio == 'P' || radio == 'F' || radio == 'FP') {
            this.filter = event.target.value//asignacion cuando se da click en cada radio
          }
          
          var urlMiembros = Const.apiURL + '/miembro?filter=' + this.filter + '&page=' + page + '&search=' + this.search
          
          //Condicion para URLGlobal
          if (this.$store.state.condicionUrl) {
            urlMiembros = this.$store.state.urlGlobal
            this.filter = this.$store.state.filter
          }else{
            this.$store.state.urlGlobal = urlMiembros
          }

          axios.get(urlMiembros).then(response => {
              this.miembros     = response.data.miembros.data
              this.pagination = response.data.pagination
          });

          this.$store.state.condicionUrl = false//Cambiando condicion al inicilizar
          this.$store.state.filter = this.filter//Iniclizando el estado
        },
        age: function (d) {
                return moment().diff(d, 'years',false);
        },
        tipoForm: function (e) {
          if (e == 'F') return 'FACILITADOR'
          else if(e == 'P') return 'PARTICIPANTE'
            else return 'FAC. Y PART.'
        },
        changePage: function (page) {
            this.pagination.current_page = page
            this.getMiembros(page)
        },
        vacioInputSearch: function () {
          if (this.search == '') return this.getMiembros()
        },
        deleteMiembro: function (id) {
            var url = Const.apiURL + '/miembro/' + id;
            axios.delete(url).then(response => {//destroy desde laravel
              if (response.data.data == 'miembro_inactivo') {
                this.showDelete = null
                this.getMiembros();
                toastr.info('Miembro se encuentra vinculado con otros Modulo. Se ha cambiado la CONDICION de INACTIVO.')
              }else{
                this.getMiembros();
                toastr.warning('Miembro Eliminado Exitosamente.')
              }
            }).catch(error => {
                this.getMiembros();
                console.clear();
            });
            this.methodisDisabledButtonRepor()
        },
        methodIsActivedButtonReport: function () {
          if (this.isActivedButtonReport) this.isActivedButtonReport = false
          else this.isActivedButtonReport = true
        },
        methodisDisabledButtonRepor: function () {
          var urlMiembros = Const.apiURL + '/isbuttonReportMiembro/'
          axios.get(urlMiembros).then(response => {
              this.isDisabledButtonRepor = response.data
          });
        },
        reporte: function (params) {
          window.open(Const.apiURL + '/reporte-miembro/' + params, '_blank');
        }
    },
		components: {
			'app-title': Title
		}
	}
</script>

<style>
	.table th{
		text-align: center;
	}
</style>