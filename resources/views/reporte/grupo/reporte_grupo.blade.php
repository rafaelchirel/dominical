@include('reporte.cabecera')

<?php if ( $data['encabezado'] != 'lisTodosNormail' && $data['encabezado'] != 'lisTodosDetallado'):; ?>

	<table>
		<thead>
			<tr><th colspan="5" style="text-align: center;background:#CECFCB;">FICHA DE GRUPO</th></tr>
			<tr>
				<th>#</th>
				<th>NOMBRE</th>
				<th>DESCRIPCION</th>
				<th>EDAD INICIO</th>
				<th>EDAD FINAL</th>
			</tr>
		</thead>
		<tbody>
			<?php $cont = 1; ?>
			@foreach($data['grupo'] as $data)
			<tr>
				<td>{{ $cont }}</td>
				<td>{{ $data->nombre }}</td>
				<td>{{ $data->descripcion }}</td>
				<td>{{ $data->edad_ini }}</td>
				<td>{{ $data->edad_fin }}</td>
			</tr>
			<?php $cont++; ?>
			@endforeach

		</tbody>
	</table>

	<table>
		<tr><th colspan="4" style="text-align: center;">Facilitadores y Auxiliares Asignados:</th></tr>
		<thead>
			<tr><th colspan="4" style="text-align: center; background:#CECFCB;">TURNO MANANA</th></tr>
			<tr>
				<th>TIPO</th>
				<th>NOMBRE Y APELLIDO</th>
				<th>CEDULA</th>
				<th>TELEFONO</th>
			</tr>
		</thead>
		<tbody>
			@if( isset($detalle['manana']) && count($detalle['manana']) )
				@foreach($detalle['manana'] as $value)
					<tr>
						<td>{{ ($value->ocupacion == 'F') ? 'FACILITADOR' : 'AUXILIAR' }}</td>
						<td>{{ $value->nombre_miembro . ' ' . $value->apellido_miembro }}</td>
						<td>{{ $value->cedula }}</td>
						<td>{{ $value->telefono }}</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="4">No se encontraron resultados vinculados.</td>
				</tr>
			@endif
		</tbody>
		
		<thead>
			<tr><th colspan="4" style="text-align: center; background:#CECFCB;">TURNO TARDE</th></tr>
			<tr>
				<th>TIPO</th>
				<th>NOMBRE Y APELLIDO</th>
				<th>CEDULA</th>
				<th>TELEFONO</th>
			</tr>
		</thead>
		<tbody>
			@if( isset($detalle['tarde']) && count($detalle['tarde']) > 0 )
				@foreach($detalle['tarde'] as $value)
					<tr>
						<td>{{ ($value->ocupacion == 'F') ? 'FACILITADOR' : 'AUXILIAR' }}</td>
						<td>{{ $value->nombre_miembro . ' ' . $value->apellido_miembro }}</td>
						<td>{{ $value->cedula }}</td>
						<td>{{ $value->telefono }}</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="4">No se encontraron resultados vinculados.</td>
				</tr>
			@endif
		</tbody>
		<br>
		<thead>
			<tr><th colspan="4" style="text-align: center; background:#CECFCB;">TURNO TARDE</th></tr>
			<tr>
				<th>TIPO</th>
				<th>NOMBRE Y APELLIDO</th>
				<th>CEDULA</th>
				<th>TELEFONO</th>
			</tr>
		</thead>
		<tbody>
			@if(isset($detalle['noche']) && count($detalle['noche']) > 0 )
				@foreach($detalle['noche'] as $value)
					<tr>
						<td>{{ ($value->ocupacion == 'F') ? 'FACILITADOR' : 'AUXILIAR' }}</td>
						<td>{{ $value->nombre_miembro . ' ' . $value->apellido_miembro }}</td>
						<td>{{ $value->cedula }}</td>
						<td>{{ $value->telefono }}</td>
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="4">No se encontraron resultados vinculados.</td>
				</tr>
			@endif
		</tbody>
	</table>

	

<?php endif; ?>


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
</style>