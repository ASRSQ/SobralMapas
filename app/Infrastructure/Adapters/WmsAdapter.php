<?php

namespace App\Infrastructure\Adapters;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WmsAdapter
{
    public function fetchWmsData(string $url, string $version): array
    {
        // Adicionando parâmetros à URL
        $urlWithParams = $url . 'ows?service=wms&version=' . $version . '&request=GetCapabilities';
    
        Log::info('Iniciando a requisição para o WMS', ['url' => $urlWithParams]);
    
        // Log da URL fornecida pelo usuário
        Log::info('URL recebida para o serviço WMS', ['url' => $urlWithParams]);
    
        $response = Http::get($urlWithParams);
    
        if ($response->failed()) {
            Log::error('Falha ao acessar o serviço WMS', ['url' => $urlWithParams, 'status' => $response->status()]);
            throw new \Exception("Falha ao acessar o serviço WMS.");
        }
    
        Log::info('Resposta recebida do serviço WMS', ['status' => $response->status()]);
    
        $xml = simplexml_load_string($response->body());
        if (!$xml) {
            Log::error('Falha ao interpretar o XML do serviço WMS', ['response_body' => $response->body()]);
            throw new \Exception("Falha ao interpretar o XML do serviço WMS.");
        }
    
        Log::info('XML do serviço WMS interpretado com sucesso', ['xml' => (string)$response->body()]);
    
        $namespaces = $xml->getNamespaces(true);
        $capabilities = $xml->children($namespaces['wms'] ?? null);
    
        Log::info('Extraindo dados do XML', ['capabilities' => $capabilities]);
    
        $data = $this->extractWmsData($capabilities);
    
        Log::info('Dados extraídos do WMS', ['data' => $data]);
    
        return $data;
    }
    

    private function extractWmsData($capabilities): array
    {
        $data = [
            'service' => [
                'title' => (string) $capabilities->Service->Title ?? 'Unknown',
            ],
            'layers' => [],
        ];

        if (isset($capabilities->Capability->Layer->Layer)) {
            foreach ($capabilities->Capability->Layer->Layer as $layer) {
                $data['layers'][] = [
                    'layer_name'  => (string) $layer->Title,
                    'crs'         => isset($layer->CRS) ? (string) $layer->CRS : null,
                    'formats'     => isset($layer->Format) ? implode(", ", iterator_to_array($layer->Format)) : null,
                    'description' => isset($layer->Abstract) ? (string) $layer->Abstract : null,
                ];
            }
        }

        Log::info('Dados das camadas extraídos', ['layers' => $data['layers']]);

        return $data;
    }
}
