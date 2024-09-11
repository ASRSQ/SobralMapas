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

    public function getWmsLayer(array $params)
    {
        return $this->geoServerClient->getWms($params);
    }
}
