@include('reporte.cabecera')

<h1 id="titulo">LISTADO DETALLADO DE GRUPOS</h1>

<?php $cont=1; ?>

@foreach($data as $dat)
	<table>
		<tr><th colspan="4" style="text-align: center;background:#83EFF1;">GRUPO # {{ $cont }}</th></tr>
		<tr>
			<th>NOMBRE</th>
			<th>DESCRIPCION</th>
			<th>EDAD INICIO</th>
			<th>EDAD FINAL</th>
		</tr>
		<tr>
			<td>{{ $dat['nombre'] }}</td>
			<td>{{ $dat['descripcion'] }}</td>
			<td>{{ $dat['edad_ini'] }}</td>
			<td>{{ $dat['edad_fin'] }}</td>
		</tr>
		<tr><th colspan="4" style="text-align: center;background:#CECFCB;">Facilitadores y Auxiliares Asignados:</th></tr>
		
		<tr><th colspan="4" style="text-align: center;background:#CECFCB;">TURNO MAÑANA</th></tr>
		<tr>
			<th>TIPO</th>
			<th>CEDULA</th>
			<th>NOMBRE Y APELLIDO</th>
			<th>TELEFONO</th>
		</tr>
		@if (isset($dat['turno']['manana']))
			@foreach($dat['turno']['manana'] as $d)
				<tr>
					<td>{{ $d->ocupacion }}</td>
					<td>{{ $d->cedula }}</td>
					<td>{{ $d->nombre_miembro }}</td>
					<td>{{ $d->telefono }}</td>
				</tr>
			@endforeach
		@else
		<tr><td colspan="4">No se encontraron resultados asociados.</td></tr>
		@endif

		<tr><th colspan="4" style="text-align: center;background:#CECFCB;">TURNO TARDE</th></tr>
		<tr>
			<th>TIPO</th>
			<th>CEDULA</th>
			<th>NOMBRE Y APELLIDO</th>
			<th>TELEFONO</th>
		</tr>
		@if (isset($dat['turno']['tarde']))
			@foreach($dat['turno']['tarde'] as $d)
				<tr>
					<td>{{ $d->ocupacion }}</td>
					<td>{{ $d->cedula }}</td>
					<td>{{ $d->nombre_miembro }}</td>
					<td>{{ $d->telefono }}</td>
				</tr>
			@endforeach
		@else
		<tr><td colspan="4">No se encontraron resultados asociados.</td></tr>
		@endif

		<tr><th colspan="4" style="text-align: center;background:#CECFCB;">TURNO NOCHE</th></tr>
		<tr>
			<th>TIPO</th>
			<th>CEDULA</th>
			<th>NOMBRE Y APELLIDO</th>
			<th>TELEFONO</th>
		</tr>
		@if (isset($dat['turno']['noche']))
			@foreach($dat['turno']['noche'] as $d)
				<tr>
					<td>{{ $d->ocupacion }}</td>
					<td>{{ $d->cedula }}</td>
					<td>{{ $d->nombre_miembro }}</td>
					<td>{{ $d->telefono }}</td>
				</tr>
			@endforeach
		@else
		<tr><td colspan="4">No se encontraron resultados asociados.</td></tr>
		@endif

	</table>
	<?php $cont++; ?>
@endforeach


<style>
    table {
        border-collapse: collapse;
        text-transform: uppercase;
        margin-top: 2%;
        width: 100%;
    }

    table, td, th {
        border: 1px solid black;
        font-size: 12px;
        word-wrap: break-word;
    }
    hr {
      page-break-after: always;
      border: 0;
      margin: 0;
      padding: 0;
    }
    #titulo {
    	margin-top: 2%;
    	text-align: center;
    }
</style>