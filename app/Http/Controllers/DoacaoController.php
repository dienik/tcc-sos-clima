<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\doacao;
use App\Models\doador;
use App\Models\coletor;

class DoacaoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'recebimento' => 'required|date',
            'fk_doador' => 'required|exists:doadores,pk_doador',
            'fk_coletor' => 'required|exists:coletores,pk_coletor',
            'itens_json' => 'required'
        ]);
    
        $doacao = doacao::create([
            'recebimento' => $request->recebimento,
            'fk_doador' => $request->fk_doador,
            'fk_coletor' => $request->fk_coletor
        ]);
    
        // Salvar os itens
        $itens = json_decode($request->itens_json, true);
        foreach ($itens as $item) {
            Item::create([
                'fk_doacao' => $doacao->pk_doacao,
                'descricao' => $item['descricao'],
                'quantidade' => $item['quantidade'],
                'validade' => $item['validade'] ?? null
            ]);
        }
    
        return redirect()->route('doacoes.index')->with('success', 'Doação registrada com sucesso!');
    }
    public function create()
{
    $doadores = doador::all(); // Busca todos os doadores
    $coletores = coletor::all(); // Busca todos os coletores

    return view('doacoesItens', compact('doadores', 'coletores'));
}

}

