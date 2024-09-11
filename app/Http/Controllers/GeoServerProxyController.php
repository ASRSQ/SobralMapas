<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
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
        $params = $request->all(); // Pega todos os parâmetros da requisição

        // Faz a requisição ao GeoServer passando os parâmetros
        $response = $this->geoServerService->getWmsLayer($params);
        // Verifica se a requisição foi bem-sucedida
        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'image/png');
        } else {
            return response('Erro ao carregar a camada WMS.', 500);
        }
    }
}
