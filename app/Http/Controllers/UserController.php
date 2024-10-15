<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function  index()
    {
        $recepcionistas = User::where('perfil', 'Recepcionista')->get();
        return view('recepcionistas.index', compact('recepcionistas'));
    }

    public function crear()
    {
        return view('recepcionistas.crearRecepcionista');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            'perfil' => 'Recepcionista',
        ]);
        return redirect()->route('recepcionistas.index')->with('success', 'recepcionista creado exitosamente');
    }

    public function eliminar($id)
    {
        $user = User::findOrFail($id);
        if($user->perfil == 'Recepcionista')
        {
            $user->delete();
            return redirect()->route('recepcionistas.index')->with('success', 'recepcionista eliminado exitosamente');
        }else{
            return redirect()->route('recepcionistas.index')->with('error', 'No se puede eliminar este usuario');
        }
    }
}
