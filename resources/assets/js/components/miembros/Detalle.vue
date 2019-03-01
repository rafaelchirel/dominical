<template>
	<div>

		<app-title :title="title"></app-title>

		<div id="top" class="text-center" style="margin-bottom: 1%;">
			<router-link to="/miembros"><button class="btn btn-primary" data-toggle="tooltip" title="Regresar"><i class="fas fa-undo-alt"></i></button></router-link>
		</div>

			 <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  style="margin:0%;">
						  <tbody class="th">
							  <tr class="success">
						        <td colspan="2"><span>Detalles</span></td>
						      </tr>
							  <tr><th>CEDULA: </th><td>{{ miembro.cedula }}</td></tr>
							  <tr><th>NOMBRE: </th><td>{{ miembro.nombre }}</td></tr>
							  <tr><th>APELLIDO: </th><td>{{ miembro.apellido }}</td></tr>
							  <tr><th>SEXO: </th><td>{{ miembro.genero }}</td></tr>
							  <tr><th>FECHA_NAC: </th><td>{{ since(miembro.fecha_nac) }}</td></tr>
							  <tr><th>EDAD: </th><td>{{ age(miembro.fecha_nac) }}</td></tr>
							  <tr style="white-space: pre-wrap;"><th>EMAIL: </th><td>{{ miembro.email }}</td></tr>
							  <tr><th>TELEFONO: </th><td>{{ miembro.telefono }}</td></tr>
							  <tr><th>DIRECCION: </th><td>{{ miembro.direccion }}</td></tr>
							  <tr><th>TIPO: </th><td>{{ tipoForm(miembro.tipo) }}</td></tr>
							  <tr><th>CONDICION: </th><td>{{ miembro.condicion }}</td></tr>
						  </tbody>
						</table>

						<table class="table table-striped table-bordered table-hover"  style="margin:0%;" v-for="obs in observacion">
						<br>
						  <tbody class="th">
							  	<tr class="danger"><td colspan="2" class="text-center"><span>OBSERVACION</span></td></tr>
						      	<tr><td colspan="2" style="text-align:center;font-weight: bold;">FECHA Y HORA: {{ obs.fecha_hora }}</td></tr>
							  	<tr><td colspan="2" style="text-align:center;font-weight: bold;">DESCRIPCION</td></tr>
							  	<tr><td colspan="2">{{ obs.descripcion }}</td></tr>
						  </tbody>
						</table>

					</div>
	 		 </div>

			<div class="clearfix"></div>

		<div id="top" class="text-center" style="margin-top: 1%;">
			<a href="#top"><button class="btn btn-primary" data-toggle="tooltip" title="Regresar arriba"><i class="fas fa-long-arrow-alt-up"></i></button></a>
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
			this.getMiembro()
			this.$store.state.condicionUrl = true
		},
		data() {
			return {
				title: 'Detalle Miembro',
				miembro:{},
		        observacion: {}
			}
		},
		methods: {
		    getMiembro: function () {
		        var id = this.$route.params.id;
		        var urlApiURL = Const.apiURL + '/miembro/' + id
		          axios.get(urlApiURL).then(response => {
                    this.miembro = response.data.miembro
                    this.observacion = response.data.observacion
		          });
		    },
		    age: function (d) {
                return moment().diff(d, 'years',false);
        	},
        	since: function (e) {
        		return moment(e).format('DD/MMM/YYYY').toUpperCase();
        	},
        	tipoForm: function (e) {
	          if (e == 'F') return 'FACILITADOR'
	          else if(e == 'P') return 'PARTICIPANTE'
	          else return 'FAC. Y PART.'
	        }
		 },
		components: {
			'app-title': Title
		}
	}
</script>

<style type="text/css">
	.th tr th {
		text-align: right;
	}
</style>