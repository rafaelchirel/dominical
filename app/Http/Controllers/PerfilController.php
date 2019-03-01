<?php

namespace App\Http\Controllers;

use  App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{

    public function update (Request $request, $id) {

		$validatedData = $request->validate([
	        'nombre'     => 'required|string|max:60',
            'apellido'   => 'required|string|max:60',
            'email'      => "required|string|email|max:255|unique:users,email,{$id}",
            'pregunta'   => 'required|string|max:100',
            'respuesta'  => 'required|string|max:100'
		]);

    	$user = User::findOrFail($id);
        $user->fill([
        	'nombre' => $request->nombre,
        	'apellido' => $request->apellido,
        	'email' => $request->email,
        	'pregunta' => '¿' . $request->pregunta . '?',
        	'respuesta' => $request->respuesta,
        ]);

        if(!$user->isDirty()) return response()->json(['error' => 'Se debe de especificar al menos un valor diferente', 'code' => 422], 422);
        
        $user->update();
    }

    public function changePassword ($password, $idUser) {
    	$user = User::findOrFail($idUser);
    	$user->password = Hash::make($password);
    	$user->save();
    }

    public function userDown ($idUser) {
    	$user = User::findOrFail($idUser);
    	$user->habilitado = false;
    	$user->save();
    }
}
