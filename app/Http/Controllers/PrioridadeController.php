<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\prioridade;
use App\Models\abrigo;
use Illuminate\Support\Facades\DB;

class PrioridadeController extends Controller
{
    // Exibe a tela com prioridades e abrigos
    public function index()
    {
        $prioridades = prioridade::all();
        $abrigos = abrigo::all();
        return view('prioridades', compact('prioridades', 'abrigos'));
    }

    // Cadastra uma nova prioridade
    public function store(Request $request)
    {
        $request->validate([
            'descricao' => 'required|max:100',
        ]);

        prioridade::create([
            'descricao' => $request->descricao
        ]);

        return redirect()->route('prioridades.index')->with('success', 'prioridade cadastrada com sucesso!');
    }

    // Atribui uma prioridade a um abrigo
    public function atribuir(Request $request)
    {
        $request->validate([
            'fk_prioridades' => 'required|exists:prioridades,pk_prioridade',
            'fk_abrigo' => 'required|exists:abrigo,pk_abrigo',
            'precisando' => 'required|boolean',
        ]);

        DB::table('tem')->insert([
            'fk_prioridades' => $request->fk_prioridades,
            'fk_abrigo' => $request->fk_abrigo,
            'precisando' => $request->precisando,
        ]);

        return redirect()->route('prioridades.index')->with('success', 'prioridade atribuída ao abrigo com sucesso!');
    }
}
