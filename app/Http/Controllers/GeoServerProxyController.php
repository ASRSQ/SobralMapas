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

    /**
     * Proxy para requisição WMS personalizada.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function proxyWms(Request $request)
    {
        $params = $request->all(); // Pega todos os parâmetros da requisição

        // Faz a requisição ao GeoServer passando os parâmetros
        $response = $this->geoServerService->getMap($params);

        // Verifica se a requisição foi bem-sucedida
        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'image/png');
        } else {
            return response('Erro ao carregar a camada WMS.', 500);
        }
    }

    /**
     * Proxy para requisição GetCapabilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCapabilities()
    {
        // Faz a requisição GetCapabilities ao GeoServer
        $response = $this->geoServerService->getCapabilities();

        // Verifica se a requisição foi bem-sucedida
        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'application/xml');
        } else {
            return response('Erro ao carregar as capabilities.', 500);
        }
    }

    /**
     * Proxy para requisição GetMap.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getMap(Request $request)
    {
        $params = $request->all(); // Pega todos os parâmetros da requisição

        // Faz a requisição GetMap ao GeoServer
        $response = $this->geoServerService->getMap($params);

        // Verifica se a requisição foi bem-sucedida
        if ($response->successful()) {
            return response($response->body(), 200)
                ->header('Content-Type', 'image/png');
        } else {
            return response('Erro ao carregar o mapa.', 500);
        }
    }

    /**
     * Proxy para requisição GetFeatureInfo.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    
}
