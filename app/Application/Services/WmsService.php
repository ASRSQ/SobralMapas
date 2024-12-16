<?php

namespace App\Application\Services;

use App\Infrastructure\Models\WmsLink;
use App\Infrastructure\Models\WmsLayer;
use App\Infrastructure\Adapters\WmsAdapter;

class WmsService
{
    private $wmsAdapter;

    public function __construct(WmsAdapter $wmsAdapter)
    {
        $this->wmsAdapter = $wmsAdapter;
    }

    /**
     * Cria o WMS Link e suas camadas associadas.
     *
     * @param string $url
     * @param string $name
     * @param string $version // Novo campo para versão
     */
    public function createWmsLinkWithLayers($url, $name, $version)
    {
        \DB::beginTransaction();

        try {
            // Criar o WMS Link com a versão
            $wmsLink = new WmsLink();
            $wmsLink->url = $url;
            $wmsLink->name = $name;
            $wmsLink->version = $version; // Definindo o valor para o campo version
            $wmsLink->save(); // Salva o WMS Link

            // Buscar as camadas do WMS usando o adaptador
            $wmsData = $this->wmsAdapter->fetchWmsData($url,$version);

            // Processar as camadas e salvar no banco de dados
            foreach ($wmsData['layers'] as $layerData) {
                // Verifica se a camada já existe para evitar duplicação
                $wmsLayer = WmsLayer::firstOrNew([
                    'layer_name' => $layerData['layer_name'], // Usando 'layer_name' em vez de 'name'
                    'wms_link_id' => $wmsLink->id,
                ]);

                // Atualiza os campos da camada, caso necessário
                $wmsLayer->crs = $layerData['crs'] ?? $wmsLayer->crs; // Se não existir, mantém o valor atual
                $wmsLayer->formats = $layerData['formats'] ?? $wmsLayer->formats;
                $wmsLayer->description = $layerData['description'] ?? $wmsLayer->description;
                $wmsLayer->save(); // Salva ou atualiza a camada
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Retorna todos os WMS Links cadastrados.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllWmsLinks()
    {
        return WmsLink::all(); // Recupera todos os WMS Links do banco de dados
    }

    /**
     * Exclui um WMS Link e todas as camadas associadas a ele.
     *
     * @param int $wmsLinkId
     */
    public function deleteWmsLinkWithLayers($wmsLinkId)
    {
        \DB::beginTransaction();

        try {
            // Recupera o WMS Link
            $wmsLink = WmsLink::findOrFail($wmsLinkId);

            // Exclui as camadas associadas ao WMS Link
            WmsLayer::where('wms_link_id', $wmsLink->id)->delete();

            // Exclui o WMS Link
            $wmsLink->delete();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    /**
     * Edita o nome, a URL e a versão de um WMS Link.
     *
     * @param int $wmsLinkId
     * @param string $name
     * @param string $url
     * @param string $version // Novo campo para versão
     */
    public function updateWmsLink($id, $name, $url, $version)
    {
        // Verifique se o WMS Link existe
        $wmsLink = WmsLink::find($id);
        
        if (!$wmsLink) {
            throw new \Exception('WMS Link não encontrado!');
        }
    
        // Atualiza os dados
        $wmsLink->name = $name;
        $wmsLink->url = $url;
        $wmsLink->version = $version; // Atualiza o campo version
        $wmsLink->save();
    }

    /**
     * Retorna as camadas associadas a um WMS Link.
     *
     * @param int $wmsLinkId
     */
    public function getWmsLayersByLink($wmsLinkId)
    {
        // Verifica se o WMS Link existe
        $wmsLink = WmsLink::find($wmsLinkId);

        if (!$wmsLink) {
            throw new \Exception('WMS Link não encontrado!');
        }

        // Retorna todas as camadas associadas
        return WmsLayer::where('wms_link_id', $wmsLinkId)->get();
    }
}
