<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Exibe o formulário de login
    public function showLoginForm()
    {
        return view('login');
    }

    // Processa o login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Buscar o usuário manualmente
        $usuario = Usuario::where('email', $request->email)->first();
    
        // Verificar se o usuário existe e se a senha está correta
        if ($usuario && Hash::check($request->password, $usuario->senha)) {
            Auth::login($usuario);
            $request->session()->regenerate();
            session(['is_admin' => $usuario->administrador == 1]);
            return redirect()->route('home')->with('success', 'Login realizado com sucesso!');
        }
    
        return back()->withErrors(['email' => 'Credenciais inválidas.'])->withInput();
    }
    
    // Exibe o formulário de cadastro
    public function showRegisterForm()
    {
        return view('register');
    }

    // Processa o cadastro
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('register')->withErrors($validator)->withInput();
        }

        $usuario = Usuario::create([
            'nome' => $request->nome,
            'sobrenome' => $request->sobrenome,
            'telefone' => $request->telefone,
            'email' => $request->email,
            'senha' => bcrypt($request->password),
            'administrador' => false,
        ]);

        return redirect()->route('login')->with('success', 'Cadastro realizado com sucesso! Faça login.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout realizado com sucesso!');
    }
    
}
