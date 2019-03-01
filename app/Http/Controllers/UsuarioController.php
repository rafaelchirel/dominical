<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsuarioController extends Controller
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

        $usuario = User::search($search, $filter)->orderBy('id', 'DESC')->paginate(10);
        return $this->paginacion($usuario);
    }

    public function paginacion ($usuario = null) {
        return [
                    'pagination' => [
                                'total'         => (count($usuario) != 0) ? $usuario->total()       : 0,
                                'current_page'  => (count($usuario) != 0) ? $usuario->currentPage() : 0,
                                'per_page'      => (count($usuario) != 0) ? $usuario->perPage()     : 0,
                                'last_page'     => (count($usuario) != 0) ? $usuario->lastPage()    : 0,
                                'from'          => (count($usuario) != 0) ? $usuario->firstItem()   : 0,
                                'to'            => (count($usuario) != 0) ? $usuario->lastItem()    : 0,
                                ],
                    'usuario' => $usuario
                ];
    }

    public function habilitar ($id) {
        $usuario = User::findOrFail($id);
            if ($usuario->habilitado) $usuario->habilitado = false;
            else $usuario->habilitado = true;
        $usuario->update();

        if (\Auth::user()->id == $id) return response()->json(['sessionActual' => true]);//session actual usuario inhabilitado
        else return response()->json($usuario->habilitado);//otros usuarios
    }

    public function resetarContrasena ($id) {
        $usuario = User::findOrFail($id);
        $usuario->password = Hash::make(123456);
        $usuario->update();
        if (\Auth::user()->id == $id) return response()->json(['refresh' => true]);
    }

    public function rol ($id) {
        $usuario = User::findOrFail($id);
        if ($usuario->rol) $usuario->rol = false;
        else $usuario->rol = true;
        $usuario->update();
        if (\Auth::user()->id == $id) return response()->json(['user' => true, 'rol' => $usuario->rol]);
        else return response()->json(['user' => false, 'rol' => $usuario->rol]);
    }

    public function consultarRol () {
        if (\Auth::user()->rol) return response()->json(['rol' => true]);
        else return response()->json(['rol' => false]);
    }


    public function reporte_PDF ($params) {
        if ($params == 'todos') {
            $usuario = User::orderBy('id', 'DESC')->get();
            $data    = ['encabezado' => 'todos', 'data' => $usuario];
        } else if ($params == 'administrador') {
            $usuario = User::where('rol','=', 1)->orderBy('id', 'DESC')->get();
            $data    = ['encabezado' => 'administrador', 'data' => $usuario];
        } else if ($params == 'moderador') {
            $usuario = User::where('rol','=', 0)->orderBy('id', 'DESC')->get();
            $data    = ['encabezado' => 'moderador', 'data' => $usuario];
        } else  {
            $usuario = User::where('id','=', $params)->get();
            $data    = ['encabezado' => 'unico', 'data' => $usuario];
        }
        $pdf = \PDF::loadView('reporte.usuario.reporte_user', ['data' => $data]);
        return $pdf->stream();
    }

    public function consultarButtonReporte () {
        $todos = User::exists();
        $administrador = User::where('rol', '=', 1)->exists();
        $moderador = User::where('rol', '=', 0)->exists();

        $data = [
            'todos'         => !$todos,
            'administrador' => !$administrador,
            'moderador'     => !$moderador
        ];

       return $data;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}
