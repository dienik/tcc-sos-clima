<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\abrigo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
class AbrigoController extends Controller
{
    /**
     * Store a newly created abrigo in storage.
     */
    public function update(Request $request, $pk_abrigo)
    {
        // Validação dos dados de entrada
        $request->validate([
            'nome' => 'required|string|max:255',
            'numero' => 'required|string|max:255',
            'estado' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'capacidade_maxima' => 'nullable|integer',
        ]);

        // Encontre o abrigo pelo ID
        $abrigo = Abrigo::findOrFail($pk_abrigo);

        // Atualize os dados do abrigo
        $abrigo->nome = $request->input('nome');
        $abrigo->numero = $request->input('numero');
        $abrigo->estado = $request->input('estado');
        $abrigo->telefone = $request->input('telefone');
        $abrigo->email = $request->input('email');
        $abrigo->capacidade_maxima = $request->input('capacidade_maxima');

        // Salve as alterações
        $abrigo->save();

        // Retorne uma resposta de sucesso
        return response()->json(['message' => 'Abrigo atualizado com sucesso', 'abrigo' => $abrigo], 200);
    }
    public function edit($pk_abrigo)
{
    // Buscar o abrigo pelo ID
    $abrigo = Abrigo::findOrFail($pk_abrigo);
    
    // Retornar a view com os dados do abrigo
    return response()->json($abrigo); // Para retornar em JSON ou
    // return view('abrigos.edit', compact('abrigo')); // Para retornar uma view (se for o caso)
}
public function listar()
{
    $abrigos = \App\Models\abrigo::select('pk_abrigo', 'nome')->get();
    return response()->json($abrigos);
}



     public function index(Request $request)
     {
         $query = DB::table('abrigo as a')
             ->leftJoin('abrigado as b', 'a.pk_abrigo', '=', 'b.fk_abrigo')
             ->select(
                 'a.pk_abrigo', 
                 'a.nome', 
                 'a.cidade', 
                 'a.estado', 
                 'a.rua', 
                 'a.numero', 
                 'a.cep', 
                 'a.telefone', 
                 'a.cnpj', 
                 'a.email', // Liste todas as colunas que você precisa de 'abrigo'
                 'a.capacidade_maxima', // Adicionei esta coluna

                 DB::raw('COUNT(b.pk_abrigado) AS abrigados_count')
             )
             ->groupBy(
                 'a.pk_abrigo', 
                 'a.nome', 
                 'a.cidade', 
                 'a.estado', 
                 'a.rua', 
                 'a.numero', 
                 'a.cep', 
                 'a.telefone', 
                 'a.cnpj', 
                 'a.email', // Inclua todas as colunas aqui também
                 'a.capacidade_maxima' // Também aqui

             );
     
         if ($request->has('search')) {
             $search = $request->input('search');
             $query->where('a.nome', 'like', "%{$search}%")
                   ->orWhere('a.cidade', 'like', "%{$search}%")
                   ->orWhere('a.estado', 'like', "%{$search}%");
         }
     
         $abrigos = $query->paginate(10); // Define 10 registros por página
     
         // Adicionando a lógica para calcular a cor do status
         $abrigos->getCollection()->transform(function($abrigo) {
             // Lógica para calcular a cor do status baseado na ocupação
             $ocupacao = $abrigo->abrigados_count / $abrigo->capacidade_maxima;
     
             if ($ocupacao < 0.5) {
                 $abrigo->statusColor = 'green'; // Menos de 50% de ocupação
             } elseif ($ocupacao >= 0.5 && $ocupacao <= 0.8) {
                 $abrigo->statusColor = 'yellow'; // Entre 50% e 80% de ocupação
             } else {
                 $abrigo->statusColor = 'red'; // Mais de 80% de ocupação
             }
     
             return $abrigo;
         });
     
         return response()->json($abrigos);
     }
     
     
     

     
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'rua' => 'required|string|max:255',
            'numero' => 'required|string|max:10',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
            'cep' => 'required|string|max:9',
            'telefone' => 'nullable|string|max:20',
            'cnpj' => 'nullable|string|max:18',
            'email' => 'nullable|email|max:255',
        ]);

        // Consulta API de CEP
        $cepResponse = Http::get("https://viacep.com.br/ws/{$request->cep}/json/");
        if ($cepResponse->successful()) {
            $cepData = $cepResponse->json();
            $validatedData['rua'] = $cepData['logradouro'] ?? $validatedData['rua'];
            $validatedData['cidade'] = $cepData['localidade'] ?? $validatedData['cidade'];
            $validatedData['estado'] = $cepData['uf'] ?? $validatedData['estado'];
        }

        $abrigo = abrigo::create($validatedData);

        return redirect()->back()->with('success', 'Abrigo cadastrado com sucesso!');
    }


}
