<?php

namespace App\Infrastructure\Adapters;

use Illuminate\Support\Facades\Http;

class GeoServerClient
{

    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'http://geoserver.sobral.ce.gov.br/geoserver/ows?service=WMS';
    }

    public function getWms(array $params)
    {
        $response = Http::withHeaders([
            'Accept' => 'image/png'
        ])->get($this->baseUrl, $params);
        return $response;
    }

    public function getLegendGraphic(string $layer)
    {
        $response = Http::get($this->baseUrl, [
            'service' => 'WMS',
            'request' => 'GetLegendGraphic',
            'format' => 'image/png',
            'layer' => $layer
        ]);

        return $response;
    }
}
