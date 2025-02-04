<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Infrastructure\Models\Estatistica;
use Illuminate\Support\Facades\Log;

class EstatisticasController extends Controller
{
    public function registrar(Request $request)
    {
        Log::info("📩 Recebendo estatísticas...", ['request' => $request->all()]);
    
        // Valida os dados recebidos
        $request->validate([
            'session_id' => 'required|string|max:6',
            'mapas_selecionados' => 'required|array',
            'tempo_total' => 'required|integer',
        ]);

        $sessionId = $request->input('session_id');
        $novosMapas = $request->input('mapas_selecionados');
        $tempoTotal = $request->input('tempo_total');

        Log::info("🆔 ID da Sessão: $sessionId");
        Log::info("🗺 Mapas Selecionados:", $novosMapas);
        Log::info("⏳ Tempo total na página: {$tempoTotal} segundos");
    
        // Busca o registro existente pelo IP
        $estatistica = Estatistica::where('ip_usuario', 
        $sessionId )->first();
    
        if ($estatistica) {
            // Garante que mapas_atual sejam um array válido
            $mapasAtuais = is_string($estatistica->mapas_selecionados) 
                ? json_decode($estatistica->mapas_selecionados, true) 
                : $estatistica->mapas_selecionados;
    
            Log::info("📊 Estatística existente encontrada para o IP $sessionId ", $mapasAtuais);
    
            foreach ($novosMapas as $mapa => $contador) {
                if (isset($mapasAtuais[$mapa])) {
                    $mapasAtuais[$mapa] += $contador; // Adiciona o contador enviado
                    Log::info("🔄 Incrementando contador do mapa: $mapa, Novo valor: {$mapasAtuais[$mapa]}");
                } else {
                    $mapasAtuais[$mapa] = $contador; // Primeiro registro do mapa
                    Log::info("🆕 Novo mapa registrado: $mapa com {$contador} seleções.");
                }
            }
    
            // Atualiza o tempo total
            $estatistica->update([
                'mapas_selecionados' => $mapasAtuais,
                'tempo_total' => $estatistica->tempo_total + $tempoTotal,
            ]);
    
            Log::info("✅ Estatística atualizada com sucesso para $sessionId .");
        } else {
            // Primeiro registro do usuário
            $estatistica = Estatistica::create([
                'ip_usuario' =>$sessionId,
                'mapas_selecionados' => $novosMapas,
                'tempo_total' => $tempoTotal,
            ]);
    
            Log::info("🆕 Criando novo registro de estatística para o IP: $sessionId");
        }
    
        return response()->json(['message' => 'Estatísticas registradas com sucesso'], 200);
    }
}
