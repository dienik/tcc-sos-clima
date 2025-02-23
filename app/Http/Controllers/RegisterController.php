<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
            'email' => 'required|email|unique:usuarios,email',
            'senha' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        };

        Usuario::create([
            'nome' => $request->nome,
            'sobrenome' => $request->sobrenome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
            'administrador' => $request->has('administrador') ? 1 : 0,
        ]);

        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso! Faça login.');
    }
}
