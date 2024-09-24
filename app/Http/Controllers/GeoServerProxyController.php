<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\Services\GeoServerService;

class GeoServerProxyController extends Controller
{
    protected $geoServerService;

    public function __construct(GeoServerService $geoServerService)
    {
        $this->geoServerService = $geoServerService;
    }

    public function proxyWms(Request $request)
    {
        // Pega todos os parâmetros da requisição
        $params = $request->all();

        // Faz a requisição ao GeoServer passando os parâmetros
        $response = $this->geoServerService->getWmsLayer($params);

        // Verifica se a requisição foi bem-sucedida
        if ($response->successful()) {
            // Verifica se o corpo da resposta não está vazio ou corrompido
            if (!empty($response->body())) {
                return response($response->body(), 200)
                    ->header('Content-Type', 'image/png');  // Retorna a imagem PNG
            } else {
                // Retorna uma mensagem de erro caso o corpo esteja vazio (indica problema na camada)
                return response()->json(['message' => 'Problema ao carregar a camada. Verifique no GeoServer.'], 500);
            }
        } else {
            // Retorna uma mensagem de erro caso a requisição falhe
            return response()->json(['message' => 'Erro ao carregar a camada WMS do GeoServer.'], 500);
        }
    }


    public function  getLegendGraphic(Request $request)
    {
        $layer = $request->input('layer');

        $response = $this->geoServerService->getLegendGraphic($layer);
        if ($response->successful()) {
            return response($response->body())
                ->header('Content-Type', 'image/png')
                ->header('Cache-Control', 'public, max-age=3600'); // Cache por 1 hora;
        }

        return response()->json(['error' => 'Failed to retrieve legend graphic'], 500);
    }
}
