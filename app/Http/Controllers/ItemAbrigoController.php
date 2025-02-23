<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\abrigo;
use App\Models\item;

class ItemAbrigoController extends Controller
{
    /**
     * Exibe a view de cadastro de itens no abrigo.
     */
    public function create()
    {
        $abrigos = DB::table('abrigo')->select('pk_abrigo', 'nome')->get();
        $itens = DB::table('itens')->select('pk_itens', 'descricao', 'quantidade')->get(); // Buscar os itens
        return view('cadastrarItemAbrigo', compact('abrigos', 'itens'));
    }
    
    

    /**
     * Processa o cadastro do item no abrigo.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fk_abrigo' => 'required|exists:abrigo,pk_abrigo',
            'fk_itens' => 'required|array',
            'fk_itens.*' => 'exists:itens,pk_itens',
            'quantidade' => 'required|array',
            'quantidade.*' => 'integer|min:1',
            'observacao' => 'nullable|array',
            'observacao.*' => 'nullable|string|max:100',
        ]);
    
        // Obtém os estoques atuais dos itens
        $itensEstoque = DB::table('itens')
        ->whereIn('pk_itens', $validatedData['fk_itens'])
        ->get()
        ->keyBy('pk_itens')
        ->toArray();
    
    
        $dadosParaInserir = [];
    
        foreach ($validatedData['fk_itens'] as $index => $fk_itens) {
            $quantidadeRequisitada = $validatedData['quantidade'][$index];
    
            if ($quantidadeRequisitada > $itensEstoque[$fk_itens]->quantidade) {

                return redirect()->back()->withErrors(['quantidade' => "Estoque insuficiente para o item {$fk_itens}"]);
            }
    
            $dadosParaInserir[] = [
                'fk_abrigo' => $validatedData['fk_abrigo'],
                'fk_itens' => $fk_itens,
                'quantidade' => $quantidadeRequisitada,
                'data' => now()->toDateString(),
                'observacao' => $validatedData['observacao'][$index] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
    
        DB::table('distribuido')->insert($dadosParaInserir);
    
        return redirect()->back()->with('success', 'Itens distribuídos com sucesso!');
    }
    
}
