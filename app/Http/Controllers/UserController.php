<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function checkEmail (Request $request) {
        $user = User::where('email', '=', $request->email);
        if ($user->exists()) return response()->json($user->first());
        else return response()->json(false, 500);
    }

    public function updatePassword (Request $request) {
        $user = User::findOrFail($request->id);
        $user->password = Hash::make($request->password);
        $user->update();
    }

    public function perfilUser () {
        $user = \Auth::user();
        return response()->json($user);
    }

    public function updateUser (Request $request) {
        $user = User::findOrFail(\Auth::user()->id);
        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->pregunta = $request->pregunta;
        $user->respuesta = $request->respuesta;
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
        //
    }
}
