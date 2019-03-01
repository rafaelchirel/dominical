@include('reporte.cabecera')

<table>
	<thead>
		@if( $data['encabezado'] == 'todos' )
			<tr><th colspan="6" style="text-align: center;">LISTADO DE USUARIO DEL SISTEMA - TODOS</th></tr>
		@elseif( $data['encabezado'] == 'administrador' )
			<tr><th colspan="6" style="text-align: center;">LISTADO DE USUARIO DEL SISTEMA - ADMINISTRADORES</th></tr>
		@elseif( $data['encabezado'] == 'moderador' )
			<tr><th colspan="6" style="text-align: center;">LISTADO DE USUARIO DEL SISTEMA - MODERADORES</th></tr>
		@else
			<tr><th colspan="6" style="text-align: center;">USUARIO DEL SISTEMA</th></tr>
		@endif

		<tr>
			<th>#</th>
			<th>ID</th>
			<th>NOMBRE Y APELLIDO</th>
			<th>EMAIL</th>
			<th>ROL</th>
			<th>HABILITADO</th>
		</tr>
	</thead>
	<tbody>
		<?php $cont=1; ?>
		@foreach($data['data'] as $data)
		<tr>
			<td>{{ $cont }}</td>
			<td>{{ $data->id }}</td>
			<td>{{ $data->nombre . ' ' . $data->apellido }}</td>
			<td>{{ $data->email }}</td>
			<td>{{ ($data->rol) ? 'ADMINISTRADOR' : 'MODERADOR' }}</td>
			<td>{{ ($data->habilitado) ? 'HABILITADO' : 'NO HABILITADO' }}</td>
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