<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\abrigado;
use App\Models\abrigo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AbrigadoController extends Controller

{
    public function edit($pk_abrigo)
    {
        // Buscar o abrigo pelo ID
        $abrigado = abrigado::findOrFail($pk_abrigo);
        
        // Retornar a view com os dados do abrigo
        return response()->json($abrigado); // Para retornar em JSON ou
        // return view('abrigos.edit', compact('abrigo')); // Para retornar uma view (se for o caso)
    }
    public function update(Request $request, $id)
    {
        $abrigado = abrigado::findOrFail($id);
    
        $request->validate([
            'nome' => 'nullable|string|max:255',
            'sobrenome' => 'nullable|string|max:255',
            'cidade_origem' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'data_entrada' => 'nullable|date',
            'abrigado.data_saida'=> 'nullable|date',
             'abrigado.informacoes'=> 'nullable|string|max:255'
        ]);
    
        $abrigado->update($request->all());
    
        return response()->json(['success' => true, 'message' => 'Dados do abrigado atualizados com sucesso!']);
    }
    public function listar()
    {
        $abrigo = abrigo::select('pk_abrigo', 'nome', 'cidade')->get();
        dd($abrigo); // Verifica se os dados estão sendo recuperados corretamente
        return response()->json($abrigo);
    }
    
    public function index(Request $request)
    {
        $query = DB::table('abrigado')
            ->join('abrigo', 'abrigado.fk_abrigo', '=', 'abrigo.pk_abrigo')
            ->select(
                'abrigado.pk_abrigado', 
                'abrigado.nome', 
                'abrigado.sobrenome', 
                'abrigado.fk_abrigo', 
                'abrigo.nome as nome_abrigo',
                'abrigado.cidade_origem', 
                'abrigado.telefone', 
                'abrigado.data_entrada',
                 'abrigado.data_saida',
                 'abrigado.informacoes'
            );
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('abrigado.nome', 'like', "%{$search}%")
                  ->orWhere('abrigado.sobrenome', 'like', "%{$search}%")
                  ->orWhere('abrigado.cidade_origem', 'like', "%{$search}%")
                  ->orWhere('abrigo.nome', 'like', "%{$search}%");
            });
        }
    
       
        $abrigado = $query->paginate(10); // Define 10 registros por página
     
        return response()->json($abrigado);
    }
    
    

    public function create()
    {
        return view('abrigados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fk_abrigo' => 'required|integer',
            'nome' => 'required|string|max:255',
            'sobrenome' => 'required|string|max:255',
            'data_entrada' => 'nullable|date',
            'data_saida' => 'nullable|date',
            'cidade_origem' => 'nullable|string|max:255',
            'informacoes' => 'nullable|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'itemPrioridade' => 'nullable|string|max:255',
        ]);

        abrigado::create($request->all());

        return response()->json(['success' => true, 'message' => 'Abrigado cadastrado com sucesso!']);
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);
    
        $file = $request->file('csv_file');
        $handle = fopen($file, 'r');
        $header = fgetcsv($handle, 1000, ',');
    
        while ($row = fgetcsv($handle, 1000, ',')) {
            $data = array_combine($header, $row);
            if (!isset($data['nome']) || !isset($data['sobrenome']) || !isset($data['fk_abrigo'])) continue;
    
            abrigado::create([
                'fk_abrigo' => $data['fk_abrigo'],
                'nome' => $data['nome'],
                'sobrenome' => $data['sobrenome'],
                'data_entrada' => $data['data_entrada'] ?? null,
                'cidade_origem' => $data['cidade_origem'] ?? null,
                'informacoes' => 'nullable|string|max:255',
                'telefone' => $data['telefone'] ?? null,
                'itemPrioridade' => $data['itemPrioridade'] ?? null,
            ]);
        }
    
        fclose($handle);
    
        return response()->json(['success' => true, 'message' => 'Abrigados importados com sucesso!']);
    }

    public function getAbrigos()
    {
        $abrigos = abrigo::select('pk_abrigo', 'nome', 'cidade')->get();
        return response()->json($abrigos);
    }

    public function downloadCsv()
    {
        $csvContent = "fk_abrigo,nome,sobrenome,data_entrada,cidade_origem, informacoes, telefone,itemPrioridade\n1,João,Silva,2023-10-01,São Paulo, sem info, 11987654321,roupa p";
        $fileName = "modelo_abrigados.csv";
        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="'.$fileName.'"');
    }
}
