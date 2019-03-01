<?php

namespace App\Http\Controllers;

use App\Miembro;
use Carbon\Carbon;
use App\Clase_miembro;
use App\Grupo_facilitador;
use App\Observacion_clase;
use Illuminate\Http\Request;
use App\Observacion_inactivo;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\MiembroRequest;

class MiembroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()):

            $tipo = $request->filter;
            $search = $request->search;

            if ($request->filter == 'T') {
                    $miembros = Miembro::todos($search)->orderBy('id', 'DESC')->paginate(10);
            }else if($request->filter == 'P'){
                    $miembros = Miembro::search($tipo, $search)->orderBy('id', 'DESC')->paginate(10);
            }else if($request->filter == 'F'){
                    $miembros = Miembro::search($tipo, $search)->orderBy('id', 'DESC')->paginate(10);
            }else if($request->filter == 'FP'){
                    $miembros = Miembro::search($tipo, $search)->orderBy('id', 'DESC')->paginate(10);
            }

            return $this->paginacion($miembros);

        endif;
    }

    public function paginacion ($miembros = null) {
        return ['pagination' => [
                            'total'         => (count($miembros) != 0) ? $miembros->total()       : 0,
                            'current_page'  => (count($miembros) != 0) ? $miembros->currentPage() : 0,
                            'per_page'      => (count($miembros) != 0) ? $miembros->perPage()     : 0,
                            'last_page'     => (count($miembros) != 0) ? $miembros->lastPage()    : 0,
                            'from'          => (count($miembros) != 0) ? $miembros->firstItem()   : 0,
                            'to'            => (count($miembros) != 0) ? $miembros->lastItem()    : 0,
                            ],
                            'miembros' => $miembros
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
    public function store(MiembroRequest $request)
    {
        if($request->ajax()){
            $miembro = Miembro::create($request->all());

            if ($request->descripcion) {
                $observacion = new Observacion_inactivo ();
                $observacion->fecha_hora  = date("Y-m-d H:i:s");
                $observacion->descripcion = $request->descripcion;
                $observacion->miembro_id  = $miembro->id;
                $observacion->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Miembro $miembro)
    {
        $observacion = Observacion_inactivo::where('miembro_id', '=', $miembro->id)->get();
        $data = ['miembro'=> $miembro, 'observacion' => $observacion];
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Miembro $miembro)
    {
        return $miembro;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MiembroRequest $request, Miembro $miembro)
    {
        if ($request->ajax()):

            $miembro->fill($request->all());
            if (!$miembro->isDirty()) return response()->json(['error' => 'Se debe de especificar al menos un valor diferente', 'code' => 422], 422);
            $miembro->update();

            if ($request->descripcion) {
                $observacion = new Observacion_inactivo ();
                $observacion->fecha_hora  = date("Y-m-d H:i:s");
                $observacion->descripcion = $request->descripcion;
                $observacion->miembro_id  = $miembro->id;
                $observacion->save();
                $this->deleteVinculoMiembro($miembro->id);
            }

        endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Miembro $miembro)
    {
        $this->deleteVinculoMiembro($miembro->id);

        $clase_miembro = Clase_miembro::where('miembro_id', '=', $miembro->id)->exists();
        $grupo_facilitador = Grupo_facilitador::where('miembro_id','=',$miembro->id)->exists();

        if ($clase_miembro || $grupo_facilitador) {
            $miembro->condicion = 'inactivo';
            $miembro->update();
            return response()->json(['data' => 'miembro_inactivo']);
        }
        $miembro->delete();
    }

    public function deleteVinculoMiembro($miembro) {
        /*
            Metodo para eliminar miembro en: tabla:clases_miembros que este como clase no impartida
            y eliminar en grupo_facilitador
        */
        //consultando si miembro existe
        $clase_miembro = DB::table('clases_miembros as cm')
        ->join('clases as c', 'c.id', '=', 'cm.clase_id')
        ->select('cm.id', 'c.id as clase_id')
        ->where('cm.miembro_id', '=', $miembro)
        ->where('c.impartida', '=', false)
        ->get();
        //consultando si miembro existe
        $grupo_facilitador = Grupo_facilitador::where('miembro_id','=', $miembro)->get();

        if (count($clase_miembro) > 0) {
            foreach ($clase_miembro as $cm) {
                //consulto si esta clase no tiene observacion para poder eliminar miembro
                $observacion = Observacion_clase::where('clase_id', '=', $cm->clase_id)->exists();
                if (!$observacion) Clase_miembro::findOrFail($cm->id)->delete();
            }
        }
        if (count($grupo_facilitador) > 0) {
            foreach ($grupo_facilitador as $gf) Grupo_facilitador::findOrFail($gf->id)->delete();
        }
    }

    public function isActiveButtonReporte () {
        $data = [
            'todos' => Miembro::exists(),
            'participantes' => Miembro::where('tipo', '=', 'P')->exists(),
            'facilitadores' => Miembro::where('tipo', '=', 'F')->exists(),
            'fac_part' => Miembro::where('tipo', '=', 'FP')->exists()
        ];
        return response()->json($data);
    }

    public function reporte_miembro ($params) {
        if ($params == 'todos') {
         $cabecera = 'FICHA DE TODOS LOS MIEMBROS';
         $data = Miembro::where('deleted_at', '=', null)->get();
        }
        elseif ($params == 'participantes') {
            $cabecera = 'FICHA DE TODOS LOS PARTICIPANTES';
            $data = Miembro::where('deleted_at', '=', null)->where('tipo', '=', 'P')->get();
        } elseif ($params == 'facilitadores') {
            $cabecera = 'FICHA DE TODOS LOS FACILITADORES';
            $data = Miembro::where('deleted_at', '=', null)->where('tipo', '=', 'F')->get();
        }elseif ($params == 'fac_part') {
            $cabecera = 'FICHA DE TODOS LOS FACILITADORES Y PARTICIPANTES';
            $data = Miembro::where('deleted_at', '=', null)->where('tipo', '=', 'FP')->get();
        } else {
            $cabecera = 'FICHA DE MIEMBRO';
            $data = Miembro::where('deleted_at', '=', null)->where('id', '=', $params)->get();
        } 
        
        $pdf = \PDF::loadView('reporte.miembro.miembro', ['data' => $data, 'cabecera' => $cabecera]);
        return $pdf->stream();
    }
}
