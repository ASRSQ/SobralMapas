<?php

namespace App\Application\Services;

use App\Domain\Repositories\ILayerRepository;
use App\Domain\Entities\Layer;

class LayerService
{
    protected $layerRepository;

    public function __construct(ILayerRepository $layerRepository)
    {
        $this->layerRepository = $layerRepository;
    }

    // Método para obter todos os layers
    public function getAll()
    {
        $layers = $this->layerRepository-> getAllLayers();

        return array_map(function ($layer) {
            return [
                'id' => $layer->getId(),
                'name' => $layer->getName(),
                'layer_name' => $layer->getLayerName(),
                'description' => $layer->getDescription(),
                'subcategory' => $layer->getSubcategory()->getId(), // Supondo que o relacionamento é um objeto de Subcategory
                'image_path' => $layer->getImagePath(),
                'max_scale' => $layer->getMaxScale(),
                'symbol' => $layer->getSymbol(),
            ];
        }, $layers);
    }

    // Método para encontrar um layer pelo ID
    public function findById(string $id): ?array
    {
        $layer = $this->layerRepository->findById($id);

        if (!$layer) {
            return null;
        }

        return [
            'id' => $layer->getId(),
            'name' => $layer->getName(),
            'layer_name' => $layer->getLayerName(),
            'description' => $layer->getDescription(),
            'subcategory' => $layer->getSubcategory()->getId(),
            'image_path' => $layer->getImagePath(),
            'max_scale' => $layer->getMaxScale(),
            'symbol' => $layer->getSymbol(),
        ];
    }

    // Método para criar um novo layer
    public function create(array $data): Layer
    {
        // Aqui você pode validar os dados antes de passar para o repositório
        $layer = $this->layerRepository->create($data);

        return $layer;
    }

    // Método para atualizar um layer
    public function update(Layer $layer): void
    {
        $this->layerRepository->update($layer);
    }

    // Método para deletar um layer
    public function delete(Layer $layer): void
    {
        $this->layerRepository->delete($layer);
    }

    // Verifica se um layer existe pelo nome
    public function existByName(string $name): bool
    {
        return $this->layerRepository->existByName($name);
    }
}
