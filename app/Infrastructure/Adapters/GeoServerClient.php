<?php

namespace App\Infrastructure\Adapters;

use Illuminate\Support\Facades\Http;

class GeoServerClient
{

    protected $baseUrl;

    public function __construct()
    {
        // Atualizar para HTTP
        $this->baseUrl = 'http://geoserver.sobral.ce.gov.br/geoserver/ows';
    }

    /**
     * Envia uma requisição para o GeoServer para obter as capabilities WMS.
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function getCapabilities()
    {
        $params = [
            'service' => 'WMS',
            'version' => '1.3.0',
            'request' => 'GetCapabilities',
        ];

        return $this->sendRequest($params);
    }

    /**
     * Envia uma requisição GetMap para o GeoServer para renderizar um mapa.
     *
     * @param array $params
     * @return \Illuminate\Http\Client\Response
     */
    public function getMap(array $params)
    {
       
        return $this->sendRequest($params);
    }

    /**
     * Função auxiliar para enviar uma requisição ao GeoServer com os parâmetros fornecidos.
     *
     * @param array $params
     * @return \Illuminate\Http\Client\Response
     */
    protected function sendRequest(array $params)
    {
        return Http::withHeaders([
            'Accept' => $params['format'] ?? 'image/png',
        ])->get($this->baseUrl, $params);
    }
}
