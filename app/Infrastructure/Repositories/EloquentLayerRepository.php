<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Layer;
use App\Domain\Repositories\ILayerRepository;
use App\Infrastructure\Models\Layer as EloquentLayer;

class EloquentLayerRepository implements ILayerRepository
{
    public function getAll(): array
    {
        $layers = EloquentLayer::all();
        return $layers->map(fn($layer) => new Layer(
            $layer->id,
            $layer->name,
            $layer->layer,
            $layer->description,
            $layer->subcategory_id
        ))->toArray();
    }

    public function findById(string $id): ?Layer
    {
        $layer = EloquentLayer::find($id);
        if (!$layer) {
            return null;
        }
        return new Layer(
            $layer->id,
            $layer->name,
            $layer->layer,
            $layer->description,
            $layer->subcategory_id
        );
    }

    public function save(Layer $layer): void
    {
        $eloquentLayer = EloquentLayer::find($layer->getId()) ?? new EloquentLayer();
        $eloquentLayer->id = $layer->getId();
        $eloquentLayer->name = $layer->getName();
        $eloquentLayer->layer = $layer->getLayer();
        $eloquentLayer->description = $layer->getDescription();
        $eloquentLayer->subcategory_id = $layer->getSubcategoryId();
        $eloquentLayer->save();
    }

    public function delete(Layer $layer): void
    {
        $eloquentLayer = EloquentLayer::find($layer->getId());
        if ($eloquentLayer) {
            $eloquentLayer->delete();
        }
    }
}
