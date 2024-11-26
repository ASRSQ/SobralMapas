<?php

namespace App\Infrastructure\Adapters;
use App\Infrastructure\Models\WmsLink;
use App\Infrastructure\Models;
use Illuminate\Support\Facades\Http;

class WmsService
{
    public function fetchAndStoreWmsData($url)
    {
        // Buscar o XML de Capabilities do WMS
        $response = Http::get($url . '?service=wms&version=1.3.0&request=GetCapabilities');
        
        if ($response->failed()) {
            throw new \Exception("Falha ao acessar o serviço WMS.");
        }

        $xml = simplexml_load_string($response->body());
        $namespaces = $xml->getNamespaces(true);
        $capabilities = $xml->children($namespaces['wms']);

        // Salvar o link WMS
        $wmsLink = WmsLink::create([
            'name' => (string) $xml->Service->Title,
            'url'  => $url
        ]);

        // Salvar camadas associadas ao link WMS
        foreach ($capabilities->Capability->Layer->Layer as $layer) {
            WmsLayer::create([
                'wms_link_id' => $wmsLink->id,
                'layer_name'  => (string) $layer->Title,
                'crs'         => (string) $layer->CRS,
                'formats'     => implode(", ", iterator_to_array($layer->Format)),
                'description' => $layer->Abstract ?? null
            ]);
        }

        return $wmsLink;
    }
}
