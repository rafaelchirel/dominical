<?php

namespace App\Http\Controllers;

use App\Clase;
use App\Grupo;
use App\Miembro;
use Carbon\Carbon;
use App\Clase_miembro;
use App\Grupo_facilitador;
use App\Observacion_clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ClaseRequest;

class ClaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = trim($request->filter);
        $search = trim($request->search);

        if ($filter == 'I') {
            if ($search != '') {
               $clase = DB::table('clases as c')
                        ->join('grupos as g', 'g.id', 'c.grupo_id')
                        ->select('c.id', 'c.nombre', 'c.fecha', 'c.hora_entrada', 'c.hora_salida', 'g.nombre as grupo')
                        ->orWhere('c.nombre', 'LIKE', "%{$search}%")
                        ->where('c.impartida', '=', true)
                        ->where('c.deleted_at', '=', null)
                        ->orWhereDate('c.fecha', '=', "{$search}")
                        ->where('c.impartida', '=', true)
                        ->where('c.deleted_at', '=', null)
                        ->paginate(10);
            }else {
               $clase = DB::table('clases as c')
                        ->join('grupos as g', 'g.id', 'c.grupo_id')
                        ->select('c.id', 'c.nombre', 'c.fecha', 'c.hora_entrada', 'c.hora_salida', 'g.nombre as grupo')
                        ->where('c.impartida', '=', true)
                        ->where('c.deleted_at', '=', null)
                        ->paginate(10);
            }
        } else if ($filter == 'NI') {
            if ($search != '') {
               $clase = DB::table('clases as c')
                        ->join('observaciones_clases as ob', 'c.id', '=', 'ob.clase_id')
                        ->join('grupos as g', 'g.id', 'c.grupo_id')
                        ->select('c.id', 'c.nombre', 'c.fecha', 'c.hora_entrada', 'c.hora_salida', 'g.nombre as grupo')
                        ->orWhere('c.nombre', 'LIKE', "%{$search}%")
                        ->where('c.impartida', '=', false)
                        ->where('c.deleted_at', '=', null)
                        ->orWhereDate('c.fecha', '=', "{$search}")
                        ->where('c.impartida', '=', false)
                        ->where('c.deleted_at', '=', null)
                        ->paginate(10);
            } else {
               $clase = DB::table('clases as c')
                ->join('observaciones_clases as ob', 'c.id', '=', 'ob.clase_id')
                ->join('grupos as g', 'g.id', 'c.grupo_id')
                ->select('c.id', 'c.nombre', 'c.fecha', 'c.hora_entrada', 'c.hora_salida', 'g.nombre as grupo')
                ->where('c.impartida', '=', false)
                ->where('c.deleted_at', '=', null)
                ->paginate(10);
            }

        } else if ($filter == 'E') {
            $clase_excluir = Observacion_clase::select('clase_id')->get()->toArray();

            if ($search != '') {
               $clase = DB::table('clases as c')
                        ->join('grupos as g', 'g.id', 'c.grupo_id')
                        ->select('c.id', 'c.nombre', 'c.fecha', 'c.hora_entrada', 'c.hora_salida', 'g.nombre as grupo')
                        ->orWhere('c.nombre', 'LIKE', "%{$search}%")
                        ->where('c.impartida', '=', false)
                        ->whereNotIn('c.id', $clase_excluir)
                        ->where('c.deleted_at', '=', null)
                        ->orWhereDate('c.fecha', '=', "{$search}")
                        ->where('c.impartida', '=', false)
                        ->whereNotIn('c.id', $clase_excluir)
                        ->where('c.deleted_at', '=', null)
                        ->paginate(10);
            }else {
               $clase = DB::table('clases as c')
                        ->join('grupos as g', 'g.id', 'c.grupo_id')
                        ->select('c.id', 'c.nombre', 'c.fecha', 'c.hora_entrada', 'c.hora_salida', 'g.nombre as grupo')
                        ->where('c.impartida', '=', false)
                        ->whereNotIn('c.id', $clase_excluir)
                        ->where('c.deleted_at', '=', null)
                        ->paginate(10);
            }
        }

        return $this->paginacion($clase);
    }

    public function paginacion ($clase = null) {
        return ['pagination' => [
                            'total'         => (count($clase) != 0) ? $clase->total()       : 0,
                            'current_page'  => (count($clase) != 0) ? $clase->currentPage() : 0,
                            'per_page'      => (count($clase) != 0) ? $clase->perPage()     : 0,
                            'last_page'     => (count($clase) != 0) ? $clase->lastPage()    : 0,
                            'from'          => (count($clase) != 0) ? $clase->firstItem()   : 0,
                            'to'            => (count($clase) != 0) ? $clase->lastItem()    : 0,
                            ],
                            'clase' => $clase
                ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getGrupos()
    {
        return Grupo::get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClaseRequest $request)
    {
        $clase = Clase::create([
            'nombre'       => $request->nombre,
            'descripcion'  => $request->descripcion,
            'fecha'        => \Carbon\Carbon::parse($request->hora_entrada)->format('Y-m-d'),
            'hora_entrada' => \Carbon\Carbon::parse($request->hora_entrada)->format('H:i'),
            'hora_salida'  => \Carbon\Carbon::parse($request->hora_salida)->format('H:i'),
            'grupo_id'     => $request->grupo_id,
        ]);

        $this->asignacionAutomaticaMiembroClase($clase->grupo_id,$clase->fecha,$clase->hora_entrada,$clase->hora_salida,$request->turno_facilitador,$clase->id);
        return response()->json($clase->id);
    }

    public function asignacionAutomaticaMiembroClase ($grupo_id,$fecha,$hora_entrada,$hora_salida,$turno_facilitador,$clase_id)
    {
        $data = [];

        //Consultando clase_miembros
        $clase_miembro = Clase_miembro::where('clase_id','=',$clase_id);
        if ($clase_miembro->exists()) $clase_miembro->delete();
        
        //consulta
        $fac_grupo = Grupo_facilitador::where('grupo_id', '=', $grupo_id);
        $participantes = Miembro::orWhere('tipo', '=', 'FP')->orWhere('tipo','=','P');
        $grupo = Grupo::findOrFail($grupo_id);

        if ($fac_grupo->exists()) {
            foreach ($fac_grupo->get() as $fg) {
                if (!$this->consultarMiembroClaseAsignado($fecha,$hora_entrada,$hora_salida,$fg->miembro_id)) {
                    if ($fg->turno == $turno_facilitador) {
                        array_push($data, ['clase_id' => $clase_id,'miembro_id' => $fg->miembro_id, 'ocupacion' => $fg->ocupacion, 'asistencia' => 'espera']);
                    }
                }
            }
        }

        if ($participantes->exists()) {
            foreach ($participantes->get() as $p):
                $edad = Carbon::createFromDate(Carbon::parse($p->fecha_nac)->format('Y'),Carbon::parse($p->fecha_nac)->format('m'),Carbon::parse($p->fecha_nac)->format('d'))->age;

                if (!$this->consultarMiembroClaseAsignado($fecha,$hora_entrada,$hora_salida,$p->id)) {
                    if ($edad >= $grupo->edad_ini && $edad <= $grupo->edad_fin) {
                        if (count($data) > 0) {
                            for ($i=0; $i < count($data); $i++) { 
                                if ($data[$i]['miembro_id'] != $p->id) {
                                    array_push($data, ['clase_id' => $clase_id,'miembro_id' => $p->id, 'ocupacion' => 'P', 'asistencia' => 'espera']);
                                }
                            }
                        }else{
                            array_push($data, ['clase_id' => $clase_id,'miembro_id' => $p->id, 'ocupacion' => 'P', 'asistencia' => 'espera']);
                        }
                    }
                }
            endforeach;
        }

        $j = 0;
        while ($j < count($data)) {
            $clase_miembro = new Clase_miembro($data[$j]);
            $clase_miembro->save();
            $j++;
        }

        return response()->json($clase_id);
    }

    public function consultarMiembroClaseAsignado ($fecha,$hora_entrada,$hora_salida,$miembro_id)
    {
        return DB::table('clases_miembros as cm')->join('clases as c', 'c.id', '=', 'cm.clase_id')
        ->whereDate('c.fecha',    '=', $fecha)
        ->where('c.hora_entrada', '>=',$hora_entrada)
        ->where('c.hora_salida',  '<=',$hora_salida)
        ->where('cm.miembro_id',  '=', $miembro_id)
        ->where('cm.asistencia',  '=', 'espera')
        ->exists();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //Mostrar Detalles
    public function show(Clase $clase)
    {
        $data = [
            'clase' => [],
            'facilitadores_auxiliares' => [],
            'participantes' => []
        ];

        $grupo = Grupo::findOrFail($clase->grupo_id);
        //$clase->grupo_id = $grupo->nombre;

        $data['clase'] = $clase;
        $data['clase']['grupo_nombre'] = $grupo->nombre;

        //participantes
        $participantes = Clase_miembro::where('clase_id', '=', $clase->id)->where('ocupacion', '=', 'P');
            if ($participantes->exists()) {
                foreach ($participantes->get() as $p) {
                    $miembro = Miembro::findOrFail($p->miembro_id);
                    $array['id']              = $p->id;
                    $array['tipo']            = $p->ocupacion;
                    $array['cedula']          = $miembro->cedula;
                    $array['nombre_apellido'] = $miembro->nombre . ' ' . $miembro->apellido;
                    $array['telefono']        = $miembro->telefono;
                    $array['asistencia']      = $p->asistencia;
                    array_push($data['participantes'],$array);
                }
            }

        //Facilitadores_auxiliares
        $facilitadores_auxiliares = Clase_miembro::orWhere('ocupacion', '=', 'F')->where('clase_id', '=', $clase->id)->orWhere('ocupacion','=', 'A')->where('clase_id', '=', $clase->id);
            if ($facilitadores_auxiliares->exists()) {
                foreach ($facilitadores_auxiliares->get() as $p) {
                    $miembro = Miembro::findOrFail($p->miembro_id);
                    $array['id']              = $p->id;
                    $array['tipo']            = $p->ocupacion;
                    $array['cedula']          = $miembro->cedula;
                    $array['nombre_apellido'] = $miembro->nombre . ' ' . $miembro->apellido;
                    $array['telefono']        = $miembro->telefono;
                    $array['asistencia']      = $p->asistencia;
                    array_push($data['facilitadores_auxiliares'],$array);            }
            }

        //Condicion Clase Espera - Impartida - No impartida
        $observacion_clases = Observacion_clase::where('clase_id', '=', $clase->id);
        $observacion_clase = Observacion_clase::where('clase_id', '=', $clase->id)->get();

            if ($observacion_clases->exists()) {
                $data['clase']['condicion'] = 'no impartida';
                $data['clase']['observacion'] = $observacion_clase[0]->descripcion;
            }else if ($clase->impartida) {
                $data['clase']['condicion'] = 'impartida';
            }else {
                $data['clase']['condicion'] = 'espera';
            }

        //Clase minimo 1 participante y 1 facilitador o auxiliar
        $facilitadores = Clase_miembro::where('clase_id', '=', $clase->id)->where('ocupacion', '=', 'F')->count();
        $participantes = Clase_miembro::where('clase_id', '=', $clase->id)->where('ocupacion', '=', 'P')->count();
        $auxiliares = Clase_miembro::where('clase_id', '=', $clase->id)->where('ocupacion', '=', 'A')->count();
        
        if ($data['clase']['condicion'] == 'espera') {
            if ($facilitadores > 0 && $participantes > 0 || $auxiliares > 0 && $participantes > 0) $data['clase']['habilitada'] = true;
            else $data['clase']['habilitada'] = false;
        }

        return response()->json($data);
    }

    public function selectGroupMiembros ($clase_id, $grupo_id) 
    {
        //Declarando Variables
        $grupo                   = Grupo::findOrFail($grupo_id);
        $clase_miembro           = Clase_miembro::where('clase_id', '=', $clase_id); 
        $facilitadores_aux_grupo = Grupo_facilitador::where('grupo_id', '=', $grupo_id);
        $miembros                = Miembro::where('condicion', '!=', 'inactivo')->get();
        $clase                   = Clase::findOrFail($clase_id);
        $data = [];

        if ($facilitadores_aux_grupo->exists()) {
            foreach ($facilitadores_aux_grupo->get() as $fa) {
                 $consulta = Clase_miembro::where('clase_id', '=', $clase_id)->where('miembro_id', '=', $fa->miembro_id);
                if ($fa->ocupacion == 'F')  {
                    if ($consulta->exists() == false && !$this->consultarMiembroClaseAsignado($clase->fecha,$clase->hora_entrada,$clase->hora_salida,$fa->miembro_id)) {
                        $data['facilitadores_grupo_aux']['id'][] = $fa->miembro_id;
                    } 
                }else {
                   if ($consulta->exists() == false && !$this->consultarMiembroClaseAsignado($clase->fecha,$clase->hora_entrada,$clase->hora_salida,$fa->miembro_id)) {
                        $data['auxiliares_grupo_aux']['id'][] = $fa->miembro_id;
                   } 
                }
            }
        }

        if (count($miembros) > 0) {
            foreach ($miembros as $m) {

                if ($m->tipo == 'P' || $m->tipo == 'FP') {
                      $edad = Carbon::createFromDate(Carbon::parse($m->fecha_nac)->format('Y'),Carbon::parse($m->fecha_nac)->format('m'),Carbon::parse($m->fecha_nac)->format('d'))->age;

                    if (!$this->consultarMiembroClaseAsignado($clase->fecha,$clase->hora_entrada,$clase->hora_salida,$m->id)) {
                        if ($edad >= $grupo->edad_ini && $edad <= $grupo->edad_fin) {
                            $array = ['id' => $m->id, 'nombre_apellido' => $m->nombre . ' ' . $m->apellido , 'ocupacion' => 'P'];
                            $data['participantes_grupo'][] = $array;
                        }
                    }
                }
                 
                if ($m->tipo == 'F' || $m->tipo == 'FP') {

                    if (!empty($data['facilitadores_grupo_aux']) && !empty($m)) {
                        foreach ($data['facilitadores_grupo_aux']['id'] as $fg) {
                            if (!empty($m)) {
                               if ($fg == $m->id) {
                                    $array = ['id' => $m->id, 'nombre_apellido' => $m->nombre . ' ' . $m->apellido , 'ocupacion' => 'F'];
                                    $data['facilitadores_grupo'][] = $array;
                                    unset($m);
                                }
                            }
                        }
                    }

                    if (!empty($data['auxiliares_grupo_aux']) && !empty($m)) {
                        foreach ($data['auxiliares_grupo_aux']['id'] as $ag) {
                            if (!empty($m)) {
                               if ($ag == $m->id) {
                                    $array = ['id' => $m->id, 'nombre_apellido' => $m->nombre . ' ' . $m->apellido , 'ocupacion' => 'F'];
                                    $data['auxiliares_grupo'][] = $array;
                                    unset($m);
                                }
                            }
                        }
                    }

                    if (!empty($m)){
                        $consulta = Clase_miembro::where('clase_id', '=', $clase_id)->where('miembro_id', '=', $m->id);
                        if ($consulta->exists() == false && !$this->consultarMiembroClaseAsignado($clase->fecha,$clase->hora_entrada,$clase->hora_salida,$m->id)) 
                        {
                            $array = ['id' => $m->id, 'nombre_apellido' => $m->nombre . ' ' . $m->apellido , 'ocupacion' => 'F'];
                            $data['facilitadores_externo'][] = $array;
                        }
                    }

                } 
            }
        }

        if (!empty($data['auxiliares_grupo_aux'])) unset($data['auxiliares_grupo_aux']);
        if (!empty($data['facilitadores_grupo_aux'])) unset($data['facilitadores_grupo_aux']);

        return  response()->json($data);
    }

    public function buttonAsignarMiembroClase (Request $request) {
        Clase_miembro::create($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Clase $clase)
    {
        return $clase;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClaseRequest $request, Clase $clase)
    {
        $clase->nombre       = $request->nombre;
        $clase->descripcion  = $request->descripcion;
        $clase->fecha        = \Carbon\Carbon::parse($request->hora_entrada)->format('Y-m-d');
        $clase->hora_entrada = \Carbon\Carbon::parse($request->hora_entrada)->format('H:i');
        $clase->hora_salida  = \Carbon\Carbon::parse($request->hora_salida)->format('H:i');
        $clase->grupo_id     = $request->grupo_id;
        $clase->update();

        return $this->asignacionAutomaticaMiembroClase($clase->grupo_id,$clase->fecha,$clase->hora_entrada,$clase->hora_salida,$request->turno_facilitador,$clase->id);
    }

    public function ofrendaClaseImpartida (Request $request) {
        if ($this->verificarListMiembroEsperaClase ($request->clase_id)) {
             return response()->json(['errors' => ['ofrenda' => ['No se puede proceder porque hay miembros en espera de ser asignada su asistencia o eliminados. Verificar el listado.']]],402);
        }else{

            $this->validate($request,
                [
                    'ofrenda' => 'required|float'
                ],
                [
                    'ofrenda.float' => 'Monto invalido o excedido del limite permitido.',
                    'ofrenda.required'            => 'Es obligatorio ingresar una ofrenda.'
                ]
            );

            $clase = Clase::findOrFail($request->clase_id);
            $clase->ofrenda = $request->ofrenda;
            $clase->impartida = true;
            $clase->update();
        }
    }

    public function asistenciaMiembro ($id,$asistencia = 'no')
    {
        $clase_miembro = Clase_miembro::findOrFail($id);
            if ($asistencia == 'si') $clase_miembro->asistencia = 'si';
            else $clase_miembro->asistencia = 'no';
        $clase_miembro->update();
    }

    public function deleteMiembroClase ($id)
    {
        $clase_miembro = Clase_miembro::findOrFail($id);
        $clase_miembro->delete();
    }

    public function claseObservacionNoImpartida (Request $request) 
    {
        if ($this->verificarListMiembroEsperaClase ($request->clase_id)) {
             return response()->json(['errors' => ['descripcion' => ['No se puede proceder porque hay miembros en espera de ser asignada su asistencia o eliminados. Verificar el listado.']]],422);
        }else{
            $this->validate($request,
                [
                    'descripcion' => 'required'
                ],
                [
                    'descripcion.required' => 'Es obligatorio ingresar una descripcion.'
                ]
            );
            Observacion_clase::create($request->all());
        }
    }

    public function verificarListMiembroEsperaClase ($clase_id) 
    {
        $clase_miembro = Clase_miembro::where('clase_id','=', $clase_id)->get();
        foreach ($clase_miembro as $cm) if ($cm->asistencia == 'espera') return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clase $clase)
    {
       $clase->delete();
    }

    public function reporteIndividual ($id) {
        //$clase = Clase::findOrFail($id);
        $clase = DB::table('clases as c')
        ->join('grupos as g', 'g.id', '=', 'c.grupo_id')
        ->select('c.nombre', 'g.nombre as grupo', 'c.descripcion', 'c.fecha', 'c.hora_entrada', 'c.hora_salida', 'c.ofrenda', 'c.impartida')
        ->where('c.id', '=', $id)
        ->first();
        $data = [];

        if ($clase->impartida == false) {//clase no impartida
            $clase_obs = Observacion_clase::where('clase_id', '=', $id)->exists();

            if ($clase_obs) {//clase no impartida
                $consulta = Clase_miembro::where('clase_id', '=', $id)->exists();
                if ($consulta) {
                    $clase_miembro = DB::table('miembros as m')->join('clases_miembros as cm', 'cm.miembro_id', '=', 'm.id')
                    ->select('cm.ocupacion', 'm.cedula', 'm.nombre', 'm.apellido', 'm.telefono', 'cm.asistencia')
                    ->where('cm.clase_id', '=', $id)
                    ->get();
                    $observacion = Observacion_clase::where('clase_id', '=', $id)->first();
                    $data['condicion'] = 'no_impartida';
                    $data['clase'] = $clase;
                    $data['observacion'] = $observacion->descripcion;
                    $data['miembros'] = $clase_miembro;

                } else {
                    $observacion = Observacion_clase::where('clase_id', '=', $id)->first();
                    $data['condicion'] = 'no_impartida';
                    $data['clase'] = $clase;
                    $data['observacion'] = $observacion->descripcion;
                    $data['miembros'] = [];
                }


            } else { //clase en espera

                $consulta = Clase_miembro::where('clase_id', '=', $id)->exists();
                if ($consulta) {

                    $clase_miembro = DB::table('miembros as m')->join('clases_miembros as cm', 'cm.miembro_id', '=', 'm.id')
                    ->select('cm.ocupacion', 'm.cedula', 'm.nombre', 'm.apellido', 'm.telefono', 'cm.asistencia')
                    ->where('cm.clase_id', '=', $id)
                    ->get();
                    
                    $data['condicion'] = 'espera';
                    $data['clase'] = $clase;
                    $data['observacion'] = [];
                    $data['miembros'] = $clase_miembro;

                } else {
                    $data['condicion'] = 'espera';
                    $data['clase'] = $clase;
                    $data['observacion'] = [];
                    $data['miembros'] = [];
                }
            }
        } else {
            $clase_miembro = DB::table('miembros as m')->join('clases_miembros as cm', 'cm.miembro_id', '=', 'm.id')
            ->select('cm.ocupacion', 'm.cedula', 'm.nombre', 'm.apellido', 'm.telefono', 'cm.asistencia')
            ->where('cm.clase_id', '=', $id)
            ->get();

            $data['condicion'] = 'impartida';
            $data['clase'] = $clase;
            $data['observacion'] = [];
            $data['miembros'] = $clase_miembro;
        }

        $pdf = \PDF::loadView('reporte.clase.reporte_clase', ['data' => $data]);
        return $pdf->stream();
        //return response()->json($data);
    }
}
