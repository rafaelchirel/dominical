@include('reporte.cabecera')

<table>
		<tr><th colspan="6" style="text-align: center;background:#CECFCB;">FICHA DE CLASE</th></tr>
		<tr>
			<th>NOMBRE</th>
			<td colspan="5">{{ $data['clase']->nombre }}</td>
		</tr>
		<tr>
			<th>GRUPO</th>
			<td colspan="5">{{ $data['clase']->grupo }}</td>
		</tr>
		<tr>
			<th>DESCRIPCION</th>
			<td colspan="5">{{ $data['clase']->descripcion }}</td>
		</tr>
		<tr>
			<th>FECHA</th><td>{{ $data['clase']->fecha }}</td>
			<th>HORA ENTRADA</th><td>{{ $data['clase']->hora_entrada }}</td>
			<th>HORA SALIDA</th><td>{{ $data['clase']->hora_salida }}</td>
		</tr>
		<tr>
			<th>OFRENDA</th><td colspan="2">{{ $data['clase']->ofrenda }}</td>
			<th>IMPARTIDA</th><td colspan="2">{{ $data['clase']->impartida }}</td>
		</tr>
		@if($data['observacion'])
			<tr><th colspan="6" style="background: #C2C2C2">OBSERVACION</th></tr>
			<tr><th colspan="6">sfsfsf</th></tr>
		@endif
</table>

<table>
		<tr><th colspan="5" style="text-align: center;background:#CECFCB;">FACILITADORES Y AUXILIARES</th></tr>
		<tr>
			<th>TIPO</th>
			<th>CEDULA</th>
			<th>NOMBRE Y APELLIDO</th>
			<th>TELEFONO</th>
			<th>ASISTENCIA</th>
		</tr>
		<?php $cont_fac = true; ?>
		@if($data['miembros'])
			@foreach($data['miembros'] as $m)
				@if($m->ocupacion == 'F' || $m->ocupacion == 'A')
					<tr>
						<td>{{ $m->ocupacion }}</td>
						<td>{{ $m->cedula }}</td>
						<td>{{ $m->nombre . ' ' . $m->apellido }}</td>
						<td>{{ $m->telefono }}</td>
						<td>{{ $m->asistencia }}</td>
					</tr>
					<?php $cont_fac = false; ?>
				@endif
			@endforeach
		@endif		
		@if($cont_fac)
			<tr><td colspan="5">No se encontraron resultados.</td></tr>
		@endif

</table>

<table>
		<tr><th colspan="5" style="text-align: center;background:#CECFCB;">PARTICIPANTES</th></tr>
		<tr>
			<th>TIPO</th>
			<th>CEDULA</th>
			<th>NOMBRE Y APELLIDO</th>
			<th>TELEFONO</th>
			<th>ACCION</th>
		</tr>
			<?php $cont_part = true; ?>
			@if($data['miembros'])
				@foreach($data['miembros'] as $m)
					@if($m->ocupacion == 'P')
						<tr>
							<td>{{ $m->ocupacion }}</td>
							<td>{{ $m->cedula }}</td>
							<td>{{ $m->nombre . ' ' . $m->apellido }}</td>
							<td>{{ $m->telefono }}</td>
							<td>{{ $m->asistencia }}</td>
						</tr>
						<?php $cont_part = false; ?>
					@endif
				@endforeach
			@endif	
			@if($cont_part)
				<tr><td colspan="5">No se encontraron resultados.</td></tr>
			@endif
</table>


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