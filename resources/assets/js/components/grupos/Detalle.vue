<template>
	<div>
		<div class="row">
            <div class="col-xs-12">

             <app-title :title="title"></app-title>

			<div class="col-xs-12">
				<!-- Search -->
				<div class="col-xs-12 col-sm-4">
					<div class="input-group add-on col-xs-12">
						<select class="form-control" v-model="asignarMiembro.miembro_id">
							<option value="" disabled selected hidden>FACILITADOR</option>
							<option v-for="f in facilitadores" v-bind:value="f.id">{{ f.cedula + ' ' + f.nombre + ' ' + f.apellido }}</option>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3">
					<div class="input-group add-on  col-xs-12">
						<select class="form-control" v-model="asignarMiembro.turno">
							<option value="" disabled selected hidden>TURNO</option>
							<option value="M">MAÑANA</option>
							<option value="T">TARDE</option>
							<option value="N">NOCHE</option>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3">
					<div class="input-group add-on  col-xs-12">
						<select class="form-control" v-model="asignarMiembro.ocupacion">
							<option value="" disabled selected hidden>OCUPACION</option>
							<option value="F">FACILITADOR</option>
							<option value="A">AUXILIAR</option>
						</select>
					</div>
				</div>
				<!-- End Search -->

                <!-- Boton Register -->
				<div class="col-xs-12 col-sm-2">
					<button type="button" :disabled="botonAsignar" class="btn btn-sm btn-warning" style="width: 100%;" @click="asignar">Asignar</button>
				</div>
                <!-- End boton Register-->
              </div>

              <br><br>

             <!--   Tabla -->
	          <div class="table-responsive">
	              <table class="table table-striped table-bordered table-hover">
	                  <thead>
	                      <tr>
	                          <th colspan="4" style="background:#AEE9E2">GRUPO</th>
	                      </tr>
	                      <tr>
	                      	 <th>NOMBRE</th>
		                     <th>DESCRIPCION</th>
		                     <th>EDAD INICIAL</th>
		                     <th>EDAD FINAL</th>
	                      </tr>
	                  </thead>
	                  <tbody>
	                  	<tr>
	                      	<td>{{ grupo.nombre }}</td>
	                      	<td>{{ grupo.descripcion }}</td>
	                      	<td>{{ grupo.edad_ini }}</td>
	                      	<td>{{ grupo.edad_fin }}</td>
		                 </tr>
	                  </tbody>
	              </table>
	          </div>
	         <!-- End  Tabla -->
			
			<h3 class="text-center" style="border-bottom: 2px solid black;">Facilitadores y Auxiliares Asignados:</h3>

			<!--   Tabla -->
	          <div class="table-responsive">
	              <table class="table table-striped table-bordered table-hover">
	                  <thead>
	                      <tr>
	                          <th colspan="5" style="background:#AEE9E2">TURNO MAÑANA</th>
	                      </tr>
	                      <tr>
	                      	<th>TIPO</th>
	                      	<th>CEDULA</th>
	                      	<th>NOMBRE Y APELLIDO</th>
	                      	<th>TELEFONO</th>
	                      	<th>ACCION</th>
	                      </tr>
	                  </thead>
	                  <tbody>
	                  	<tr v-if="grupo_facilitador.manana == ''"><td colspan="5">No se encontraron facilitadores y axuliares asociados a este turno.</td></tr>
	                  	<tr v-else="" v-for="gf in grupo_facilitador.manana">
	                      	<td>{{ gf.ocupacion == 'F' ? 'FACILITADOR' : 'AUXILIAR' }}</td>
	                      	<td>{{ gf.cedula }}</td>
	                      	<td>{{ gf.nombre }}</td>
	                      	<td>{{ gf.telefono }}</td>
	                      	<td class="text-center">
								<div v-if="showDelete != gf.id">
	                              <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="showDelete=gf.id"><i class="fas fa-times-circle"></i></button>
	                          	</div>
	                          	<div v-else="">
		                           <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="deleteMiembro(gf.id)"><i class="fas fa-times"></i></button>
		                           <button class="btn btn-default btn-xs" data-toggle="tooltip" title="Cancelar" @click="showDelete=null"><i class="fas fa-redo-alt"></i></button>
		                        </div>
		                    </td>
		                 </tr>
	                  </tbody>
	              </table>
	          </div>
	         <!-- End  Tabla -->

	         <!--   Tabla -->
	          <div class="table-responsive">
	              <table class="table table-striped table-bordered table-hover">
	                  <thead>
	                      <tr>
	                          <th colspan="5" style="background:#AEE9E2">TURNO TARDE</th>
	                      </tr>
	                      <tr>
	                      	<th>TIPO</th>
	                      	<th>CEDULA</th>
	                      	<th>NOMBRE Y APELLIDO</th>
	                      	<th>TELEFONO</th>
	                      	<th>ACCION</th>
	                      </tr>
	                  </thead>
	                  <tbody>
	                  	<tr v-if="grupo_facilitador.tarde == ''"><td colspan="5">No se encontraron facilitadores y axuliares asociados a este turno.</td></tr>
	                  	<tr v-else="" v-for="gf in grupo_facilitador.tarde">
	                      	<td>{{ gf.ocupacion == 'F' ? 'FACILITADOR' : 'AUXILIAR' }}</td>
	                      	<td>{{ gf.cedula }}</td>
	                      	<td>{{ gf.nombre }}</td>
	                      	<td>{{ gf.telefono }}</td>
	                      	<td class="text-center">
								<div v-if="showDelete != gf.id">
	                              <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="showDelete=gf.id"><i class="fas fa-times-circle"></i></button>
	                          	</div>
	                          	<div v-else="">
		                           <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="deleteMiembro(gf.id)"><i class="fas fa-times"></i></button>
		                           <button class="btn btn-default btn-xs" data-toggle="tooltip" title="Cancelar" @click="showDelete=null"><i class="fas fa-redo-alt"></i></button>
		                        </div>
		                    </td>
		                 </tr>
	                  </tbody>
	              </table>
	          </div>
	         <!-- End  Tabla -->

	         <!--   Tabla -->
	          <div class="table-responsive">
	              <table class="table table-striped table-bordered table-hover">
	                  <thead>
	                      <tr>
	                          <th colspan="5" style="background:#AEE9E2">TURNO NOCHE</th>
	                      </tr>
	                      <tr>
	                      	<th>TIPO</th>
	                      	<th>CEDULA</th>
	                      	<th>NOMBRE Y APELLIDO</th>
	                      	<th>TELEFONO</th>
	                      	<th>ACCION</th>
	                      </tr>
	                  </thead>
	                  <tbody>
	                  	<tr v-if="grupo_facilitador.noche == ''"><td colspan="5">No se encontraron facilitadores y axuliares asociados a este turno.</td></tr>
	                  	<tr v-else="" v-for="gf in grupo_facilitador.noche">
	                      	<td>{{ gf.ocupacion == 'F' ? 'FACILITADOR' : 'AUXILIAR' }}</td>
	                      	<td>{{ gf.cedula }}</td>
	                      	<td>{{ gf.nombre }}</td>
	                      	<td>{{ gf.telefono }}</td>
	                      	<td class="text-center">
								<div v-if="showDelete != gf.id">
	                              <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="showDelete=gf.id"><i class="fas fa-times-circle"></i></button>
	                          	</div>
	                          	<div v-else="">
		                           <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" @click="deleteMiembro(gf.id)"><i class="fas fa-times"></i></button>
		                           <button class="btn btn-default btn-xs" data-toggle="tooltip" title="Cancelar" @click="showDelete=null"><i class="fas fa-redo-alt"></i></button>
		                        </div>
		                    </td>
		                 </tr>
	                  </tbody>
	              </table>
	          </div>
	         <!-- End  Tabla -->

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
			this.getGrupoMiembros()
		},
		data() {
			return {
				title: 'Detalles',
				grupo: {},
				facilitadores: {},
				grupo_facilitador: {
					manana: [],
					tarde: [],
					noche: []
				},
				data: {},
				showDelete: null,
				asignarMiembro: {
					miembro_id: '',
					turno: '',
					grupo_id: this.$route.params.id,
					ocupacion: ''
				}
			}
		},
		computed: {
			botonAsignar: function () {
				if (this.asignarMiembro.turno == '' || this.asignarMiembro.grupo_id == '' || this.asignarMiembro.ocupacion == '') return true
					else false
			}
		},
		methods:{
			asignar: function () {
		        var urlApiURL = Const.apiURL + '/asignarFacilitador'
		          axios.post(urlApiURL, this.asignarMiembro).then(response => {
		          	this.grupo_facilitador.manana = []
	            	this.grupo_facilitador.tarde = []
	            	this.grupo_facilitador.noche = []
	                this.getGrupoMiembros()
		            toastr.options.positionClass = 'toast-bottom-right';
		            toastr.success('Miembro Registrado a Grupo Exitosamente')
		          }).catch(error => {
		            toastr.options.positionClass = 'toast-bottom-right';
		            toastr.error(error.response.data.error)
		          });
		    },
			getGrupoMiembros: function () {
			  var id = this.$route.params.id;
	          var urlGrupos = Const.apiURL + '/grupo/' + id
	          axios.get(urlGrupos).then(response => {
	          	this.grupo = response.data.grupo
	          	this.data = response.data.grupo_facilitador
	          	this.facilitadores = response.data.facilitadores
		          	for (var i = 0; i < this.data.length; i++) {
		          		if (this.data[i].turno == 'M') this.grupo_facilitador.manana.push(this.data[i])
		          		else if (this.data[i].turno == 'T') this.grupo_facilitador.tarde.push(this.data[i])
		          		else this.grupo_facilitador.noche.push(this.data[i])
		          	}
	          });
	        },
	        deleteMiembro: function (id) {
	        	var url = Const.apiURL + '/deleteFacilitadorGrupo/' + id;
	            axios.get(url).then(response => {
	            	this.grupo_facilitador.manana = []
	            	this.grupo_facilitador.tarde = []
	            	this.grupo_facilitador.noche = []
	                this.getGrupoMiembros()
	                toastr.options.positionClass = 'toast-bottom-right';
	                toastr.warning('Miembro Eliminado Exitosamente.')
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