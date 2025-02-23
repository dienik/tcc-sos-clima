<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\abrigo;
use Illuminate\Support\Facades\DB;
class abrigoPrioridadesController extends Controller
{
     public function index()
     {
         $abrigos = abrigo::with(['prioridades' => function ($query) {
             $query->select('prioridades.*', 't.precisando') // Usando alias 't'
                   ->join('tem as t', 'prioridades.pk_prioridade', '=', 't.fk_prioridades');
         }])->get();
     
         return view('abrigos_prioridades', compact('abrigos'));
     }
     public function removerPrioridade($abrigoId, $prioridadeId)
     {
         // Remove apenas a relação entre o abrigo e a prioridade na tabela 'tem'
         $deleted = DB::table('tem')
             ->where('fk_abrigo', $abrigoId)
             ->where('fk_prioridades', $prioridadeId)
             ->delete();
 
         if ($deleted) {
             return response()->json(['message' => 'Prioridade removida com sucesso!']);
         } else {
             return response()->json(['error' => 'Erro ao remover a prioridade.'], 500);
         }
     }
     
}

