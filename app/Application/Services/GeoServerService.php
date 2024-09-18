<?php

namespace App\Application\Services;

use App\Infrastructure\Adapters\GeoServerClient;

class GeoServerService
{
    protected $geoServerClient;

    public function __construct(GeoServerClient $geoServerClient)
    {
        $this->geoServerClient = $geoServerClient;
    }

    /**
     * Obter as capabilities do WMS
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function getCapabilities()
    {
        return $this->geoServerClient->getCapabilities();
    }

    /**
     * Obter um mapa renderizado do WMS
     *
     * @param array $params
     * @return \Illuminate\Http\Client\Response
     */
    public function getMap(array $params)
    {
        return $this->geoServerClient->getMap($params);
    }

}
