@include('reporte.cabecera')

	<table>
		<thead>
			<tr><th colspan="5" style="text-align: center;background:#CECFCB;">LISTADO DE GRUPO NORMAL</th></tr>
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
			@foreach($data['data'] as $data)
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