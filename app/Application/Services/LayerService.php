<?php

namespace App\Application\Services;

use App\Domain\Repositories\ILayerRepository;
use App\Domain\Entities\Layer;
use Illuminate\Support\Facades\Log;
use Exception;

class LayerService
{
    protected $layerRepository;

    public function __construct(ILayerRepository $layerRepository)
    {
        $this->layerRepository = $layerRepository;
    }

    // Método para criar um novo layer
    public function create(array $data): Layer
    {
        try {
            Log::info('Accessed LayerService@create', ['data' => $data]);

            $layer = $this->layerRepository->create($data);

            Log::info('Layer created successfully', ['layer_id' => $layer->getId()]);

            return $layer;
        } catch (Exception $e) {
            Log::error('Error creating layer', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'data' => $data
            ]);

            throw $e;
        }
    }
    public function existsByLayerName(string $layerName): bool
{
    try {
        Log::info('Checking if layer exists by layer_name', ['layer_name' => $layerName]);

        $exists = $this->layerRepository->existByName($layerName);

        Log::info('Layer existence check result', ['layer_name' => $layerName, 'exists' => $exists]);

        return $exists;
    } catch (\Exception $e) {
        Log::error('Error checking layer existence by layer_name', ['error' => $e->getMessage(), 'layer_name' => $layerName]);
        throw $e;
    }
}

    // Método para atualizar um layer
    public function update(int $id, array $data): void
{
    try {
        Log::info('Accessed LayerService@update', ['layer_id' => $id]);

        // Buscar camada pelo ID
        $layer = $this->layerRepository->findById($id);
        if (!$layer) {
            throw new \Exception('Camada não encontrada.');
        }

        // Atualizar atributos da camada
        $layer->setName($data['name']);
        $layer->setLayerName($data['layer_name']);
        $layer->setCrs($data['crs'] ?? null);
        $layer->setLegendUrl($data['legend_url'] ?? null);
        $layer->setType($data['type'] ?? null);
        $layer->setDescription($data['description'] ?? null);
        $layer->setOrder($data['order'] ?? null);
        $layer->setSubcategory($data['subcategory'] ?? null);
        $layer->setMaxScale($data['max_scale'] ?? null);
        $layer->setSymbol($data['symbol'] ?? null);
        $layer->setWmsLinkId($data['wms_link_id']);

        // Atualizar no repositório
        $this->layerRepository->update($layer);

        Log::info('Layer updated successfully', ['layer_id' => $layer->getId()]);
    } catch (\Exception $e) {
        Log::error('Error updating layer', [
            'error' => $e->getMessage(),
            'layer_id' => $id,
        ]);
        throw $e;
    }
}


    // Método para deletar um layer
    public function delete(int $id): void
    {
        try {
            Log::info('Accessed LayerService@delete', ['layer_id' => $id]);

            $this->layerRepository->delete($id);

            Log::info('Layer deleted successfully', ['layer_id' => $id]);
        } catch (Exception $e) {
            Log::error('Error deleting layer', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'layer_id' => $id
            ]);

            throw $e;
        }
    }

    // Método para buscar todos os layers
    public function getAll(): array
    {
        try {
            Log::info('Accessed LayerService@getAll');

            $layers = $this->layerRepository->getAllLayers();

            Log::info('Fetched all layers', ['layers_count' => count($layers)]);

            return $layers;
        } catch (Exception $e) {
            Log::error('Error fetching all layers', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    // Método para buscar layers por subcategoria
    public function getBySubcategoryId(int $subcategoryId): array
    {
        try {
            Log::info('Accessed LayerService@getBySubcategoryId', ['subcategory_id' => $subcategoryId]);

            $layers = $this->layerRepository->getAllBySubcategoryId($subcategoryId);

            Log::info('Fetched layers by subcategory', [
                'subcategory_id' => $subcategoryId,
                'layers_count' => count($layers)
            ]);

            return $layers;
        } catch (Exception $e) {
            Log::error('Error fetching layers by subcategory', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'subcategory_id' => $subcategoryId
            ]);

            throw $e;
        }
    }

    // Método para buscar layers por WMS Link
    public function getByWmsLinkId(int $wmsLinkId): array
    {
        try {
            Log::info('Accessed LayerService@getByWmsLinkId', ['wms_link_id' => $wmsLinkId]);

            $layers = $this->layerRepository->getAllByWmsLinkId($wmsLinkId);

            Log::info('Fetched layers by WMS Link', [
                'wms_link_id' => $wmsLinkId,
                'layers_count' => count($layers)
            ]);

            return $layers;
        } catch (Exception $e) {
            Log::error('Error fetching layers by WMS Link', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'wms_link_id' => $wmsLinkId
            ]);

            throw $e;
        }
    }
}
