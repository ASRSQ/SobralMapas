<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Layer;
use App\Domain\Repositories\ILayerRepository;
use App\Infrastructure\Models\Layer as EloquentLayer;

class EloquentLayerRepository implements ILayerRepository
{
    // Método para encontrar um layer pelo ID
    public function findById(int $id): ?Layer
    {
        $layer = EloquentLayer::find($id);
        if (!$layer) {
            return null;
        }

        return new Layer(
            $layer->id,
            $layer->name,
            $layer->layer_name,
            $layer->crs,
            $layer->legend_url,
            $layer->type,
            $layer->description,
            $layer->order,
            $layer->subcategory, // Relacionamento com Subcategory
            $layer->image_path,
            $layer->max_scale,
            $layer->symbol
        );
    }

    // Método para criar um novo layer
    public function create(array $data): Layer
    {
        $eloquentLayer = EloquentLayer::create($data);

        return new Layer(
            $eloquentLayer->id,
            $eloquentLayer->name,
            $eloquentLayer->layer_name,
            $eloquentLayer->crs,
            $eloquentLayer->legend_url,
            $eloquentLayer->type,
            $eloquentLayer->description,
            $eloquentLayer->order,
            $eloquentLayer->subcategory, // Relacionamento com Subcategory
            $eloquentLayer->image_path,
            $eloquentLayer->max_scale,
            $eloquentLayer->symbol
        );
    }

    // Método para atualizar um layer
    public function update(Layer $layer): void
    {
        $eloquentLayer = EloquentLayer::find($layer->getId());

        if ($eloquentLayer) {
            $eloquentLayer->name = $layer->getName();
            $eloquentLayer->layer_name = $layer->getLayerName();
            $eloquentLayer->crs = $layer->getCrs();
            $eloquentLayer->legend_url = $layer->getLegendUrl();
            $eloquentLayer->type = $layer->getType();
            $eloquentLayer->description = $layer->getDescription();
            $eloquentLayer->order = $layer->getOrder();
            $eloquentLayer->subcategory = $layer->getSubcategory();
            $eloquentLayer->image_path = $layer->getImagePath();
            $eloquentLayer->max_scale = $layer->getMaxScale();
            $eloquentLayer->symbol = $layer->getSymbol();
            $eloquentLayer->save();
        }
    }

    // Método para deletar um layer
    public function delete(int $id): void
    {
        $eloquentLayer = EloquentLayer::find($id);

        if ($eloquentLayer) {
            $eloquentLayer->delete();
        }
    }

    // Método para obter todos os layers
    public function getAllLayers(): array
    {
        $layers = EloquentLayer::all();

        return $layers->map(function ($layer) {
            return new Layer(
                $layer->id,
                $layer->name,
                $layer->layer_name,
                $layer->crs,
                $layer->legend_url,
                $layer->type,
                $layer->description,
                $layer->order,
                $layer->subcategory, // Relacionamento com Subcategory
                $layer->image_path,
                $layer->max_scale,
                $layer->symbol
            );
        })->toArray();
    }

    // Método para verificar se um layer existe pelo nome
    public function existByName(string $name): bool
    {
        return EloquentLayer::where('name', $name)->exists();
    }
}
