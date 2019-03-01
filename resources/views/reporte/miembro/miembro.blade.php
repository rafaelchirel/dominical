@include('reporte.cabecera')

<h1 id="titulo">{{ $cabecera }}</h1>

@foreach($data as $d)

<?php 
	if ($d->tipo == 'F') $d->tipo = 'FACILITADOR';
	elseif ($d->tipo == 'P') $d->tipo = 'PARTICIPANTE';
	if ($d->tipo == 'FP') $d->tipo = 'FAC_PART';
?>
	<table>
		<tr><th colspan="6" style="text-align: center;background:#CECFCB;">{{ $d->nombre . ' ' . $d->apellido }}</th></tr>
		<tr>
			<th>CEDULA</th><td>{{ $d->cedula }}</td>
			<th>SEXO</th><td>{{ $d->genero }}</td>
			<th>FECHA DE NACIMIENTO</th><td>{{ $d->fecha_nac }}</td>
		</tr>
		<tr>
			<th>TELEFONO</th><td>{{ $d->telefono }}</td>
			<th>TIPO</th><td>{{ $d->tipo  }}</td>
			<th>CONDICION</th><td>{{ $d->condicion }}</td>
		</tr>
		<tr>
			<th>EMAIL</th><td colspan="5">{{ ($d->email == '') ? '-' : $d->email }}</td>
		</tr>
	</table>
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
    	border-bottom: 1px solid black;
    }
</style>