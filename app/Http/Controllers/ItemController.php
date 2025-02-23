<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\item;
use App\Models\doacao;

class itemController extends Controller
{
    public function create()
    {
        $doacoes = doacao::all();
        return view('itens.create', compact('doacoes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fk_doacao' => 'required|exists:doacoes,pk_doacao',
            'descricao' => 'required|string|max:100',
            'quantidade' => 'required|numeric|min:1',
            'validade' => 'nullable|date'
        ]);

        item::create([
            'fk_doacao' => $request->fk_doacao,
            'descricao' => $request->descricao,
            'quantidade' => $request->quantidade,
            'validade' => $request->validade
        ]);

        return redirect()->route('itens.index')->with('success', 'item cadastrado com sucesso!');
    }
}
