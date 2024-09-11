<?php

namespace App\Infrastructure\Adapters;

use Illuminate\Support\Facades\Http;

class GeoServerClient
{

    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://geoserver.sobral.ce.gov.br/geoserver/ows';
    }

    public function getWms(array $params)
    {
        $response = Http::withHeaders([
            'Accept' => 'image/png'
        ])->get('http://geoserver.sobral.ce.gov.br/geoserver/ows', $params);
        return $response;
    }
}
