<?php

namespace App\Http\Controllers;

use App\Clase;
use App\Grupo;
use App\Miembro;
use App\Grupo_facilitador;
use App\Observacion_clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\GrupoRequest;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $grupos = Grupo::search($request->search)->orderBy('id','DESC')->paginate(10);
        return $this->paginacion($grupos);
    }

    public function paginacion ($grupos = null) {
        return ['pagination' => [
                            'total'         => (count($grupos) != 0) ? $grupos->total()       : 0,
                            'current_page'  => (count($grupos) != 0) ? $grupos->currentPage() : 0,
                            'per_page'      => (count($grupos) != 0) ? $grupos->perPage()     : 0,
                            'last_page'     => (count($grupos) != 0) ? $grupos->lastPage()    : 0,
                            'from'          => (count($grupos) != 0) ? $grupos->firstItem()   : 0,
                            'to'            => (count($grupos) != 0) ? $grupos->lastItem()    : 0,
                            ],
                 'grupos' => $grupos
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GrupoRequest $request)
    {
        if(!$request->ajax()) return false;
        Grupo::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //Detalle tabla Grupo id  y tabla Grupofacilitador
    public function show($id)
    {
        $grupo = Grupo::findOrFail($id);
        $grupo_facilitador = DB::table('grupos_facilitadores as gf')->join('miembros as m', 'gf.miembro_id', '=', 'm.id')->where('gf.grupo_id', '=', $id)
        ->select('gf.id', 'gf.ocupacion', 'gf.turno', 'm.cedula', 'm.nombre', 'm.apellido', 'm.telefono')->get();
        $facilitadores = Miembro::where('tipo', '=', 'F')->orWhere('tipo', '=', 'FP')->get();
        return ['grupo' => $grupo, 'grupo_facilitador' => $grupo_facilitador, 'facilitadores' => $facilitadores];
    }

    public function asignarFacilitador(Request $request)
    {
        $miembro_id = (int) $request->miembro_id;
        $turno      = $request->turno;
        $grupo_id   = (int) $request->grupo_id;

        $grupo_facilitador = Grupo_facilitador::where('miembro_id', '=', $miembro_id)->where('grupo_id', '=', $grupo_id)->where('turno', '=', $turno)->exists();
        if ($grupo_facilitador) return response()->json(['error' => 'Miembro ya se encuentra asignado a este turno en especifico.'],422);

        Grupo_facilitador::create($request->all());
    }

    public function deleteFacilitadorGrupo($id) 
    {
        $delete = Grupo_facilitador::findOrFail($id)->delete();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Grupo $grupo)
    {
        return $grupo;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GrupoRequest $request, Grupo $grupo)
    {
        if(!$request->ajax()) return false;
        $grupo->fill($request->all());
        if(!$grupo->isDirty()) return response()->json(['error' => 'Se debe de especificar al menos un valor diferente', 'code' => 422], 422);
        $grupo->update();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Grupo $grupo)
    {
        //Si clase esta en observacion elimino / vinculado con grupo
        $grupo_clase = Clase::where('grupo_id', '=', $grupo->id)->where('impartida', '=', 0)->get();

        foreach ($grupo_clase as $gc) {
            $clase_observacion = Observacion_clase::where('clase_id', '=', $gc->id)->exists();
            if ($clase_observacion) $grupo->delete();
        }

        //Si grupo no esta relacionado con ninguna tabla
        $grupo_clase = Clase::where('grupo_id', '=', $grupo->id)->exists();
        if(!$grupo_clase) $grupo->delete();

        //Grupo relacion a clase no impartida / no esta en observacion / clase en espera
        if ($grupo_clase) return response()->json(['error' => 'Grupo está asociadoa a clases que estan en espera de ser impartidas.'],422);

    }

    public function reporteGrupo ($params) {

        $data = [];
        $grupo_fac = Grupo_facilitador::select('grupo_id')->get();
        
        if (empty($grupo_fac)) {
            foreach ($grupo_fac as $value) {
              $data[] = $value->grupo_id;
            }
            $grupo_fac = array_unique($data);
        }

        if ($params == 'lisTodosNormail') {
            $data['encabezado'] = 'lisTodosNormail';
            $data['data'] = Grupo::orderBy('id', 'DESC')->get();
            $pdf = \PDF::loadView('reporte.grupo.reporte_grupo_listnormal', ['data' => $data ]);
            return $pdf->stream();

        } else if ($params == 'lisTodosDetallado') {

            $data['detalle'] = DB::table('grupos as g')
            ->join('grupos_facilitadores as gf', 'gf.grupo_id', '=', 'g.id')
            ->join('miembros as m', 'gf.miembro_id', '=', 'm.id')
            ->select('g.id','g.nombre', 'g.descripcion', 'g.edad_ini', 'g.edad_fin', 'gf.ocupacion', 'gf.turno', 'm.cedula', 'm.nombre as nombre_miembro', 'm.apellido as apellido_miembro', 'm.telefono')
            ->whereIn('grupo_id', $grupo_fac)
            ->where('g.deleted_at', '=', null)
            ->get();
           
            if ( count($data['detalle']) > 0) {
                foreach ($data['detalle'] as $value) {
                    //Grupo
                    $data['grupo'][$value->id]['nombre']      = $value->nombre;
                    $data['grupo'][$value->id]['descripcion'] = $value->descripcion;
                    $data['grupo'][$value->id]['edad_ini']    = $value->edad_ini;
                    $data['grupo'][$value->id]['edad_fin']    = $value->edad_fin;
                    //Turno
                    if ($value->turno == 'M') {
                        $data['grupo'][$value->id]['turno']['manana'][] = $value;
                    } elseif ($value->turno == 'T') {
                        $data['grupo'][$value->id]['turno']['tarde'][] = $value;
                    } else {
                        $data['grupo'][$value->id]['turno']['noche'][] = $value;
                    }
                }
            }
            $data['no_detalle'] = Grupo::whereNotIn('id', $grupo_fac)->get();

            if ( count($data['no_detalle']) > 0 ) {
                foreach ($data['no_detalle'] as $value) {
                    //Grupo
                    $data['grupo'][$value->id]['nombre']      = $value->nombre;
                    $data['grupo'][$value->id]['descripcion'] = $value->descripcion;
                    $data['grupo'][$value->id]['edad_ini']    = $value->edad_ini;
                    $data['grupo'][$value->id]['edad_fin']    = $value->edad_fin;
                }
            }
            unset($data['detalle']);
            unset($data['no_detalle']);
            $data = $data['grupo'];
            unset($data['grupo']);

            $pdf = \PDF::loadView('reporte.grupo.reporte_grupo_listadotodosdetallado', ['data' => $data]);
            return $pdf->stream();

        } else {
            $data['encabezado'] = 'individual';
            $data['grupo'] = Grupo::where('id', '=', $params)->get();

            $data['detalle_aux'] = DB::table('grupos as g')
            ->join('grupos_facilitadores as gf', 'gf.grupo_id', '=', 'g.id')
            ->join('miembros as m', 'gf.miembro_id', '=', 'm.id')
            ->select('g.id','g.nombre', 'g.descripcion', 'g.edad_ini', 'g.edad_fin', 'gf.ocupacion', 'gf.turno', 'm.cedula', 'm.nombre as nombre_miembro', 'm.apellido as apellido_miembro', 'm.telefono')
            ->where('g.id', '=', $params)
            ->get();
            $data['detalle'] = [];
            foreach ($data['detalle_aux'] as $value) {
                if     ($value->turno == 'M') $data['detalle']['manana'][] = $value;
                elseif ($value->turno == 'T') $data['detalle']['tarde'][]  = $value;
                else   $data['detalle']['noche'][] = $value;
            }
            unset($data['detalle_aux']);
            $pdf = \PDF::loadView('reporte.grupo.reporte_grupo', ['data' => $data , 'detalle' => $data['detalle']]);
            return $pdf->stream();
        }
    }
}
