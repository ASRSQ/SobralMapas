<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Layer;
use App\Domain\Repositories\ILayerRepository;
use App\Infrastructure\Models\Layer as EloquentLayer;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

class EloquentLayerRepository implements ILayerRepository
{
    private function mapToDomain(EloquentLayer $eloquentLayer): Layer
    {
        return new Layer(
            $eloquentLayer->id,
            $eloquentLayer->name,
            $eloquentLayer->layer_name,
            $eloquentLayer->crs,
            $eloquentLayer->legend_url,
            $eloquentLayer->type ?? 'default',
            $eloquentLayer->description ?? '',
            $eloquentLayer->order ?? 0,
            $eloquentLayer->subcategory,
            $eloquentLayer->image_path ?? '',
            $eloquentLayer->max_scale ?? 0,
            $eloquentLayer->symbol ?? '',
            $eloquentLayer->wms_link_id,
            $eloquentLayer->isPublic?? 1// Inclui o campo isPublic

        );
    }

    public function getAllLayers(): array
    {
        try {
            Log::info('Fetching all layers');

            $layers = EloquentLayer::all();

            Log::info('Fetched layers', ['count' => $layers->count()]);

            return $layers->map(fn($layer) => $this->mapToDomain($layer))->toArray();
        } catch (Exception $e) {
            Log::error('Error in getAllLayers', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function findById(int $id): ?Layer
    {
        try {
            Log::info('Accessed findById', ['layer_id' => $id]);

            $eloquentLayer = EloquentLayer::find($id);
            if (!$eloquentLayer) {
                Log::warning('Layer not found', ['layer_id' => $id]);
                return null;
            }

            return $this->mapToDomain($eloquentLayer);
        } catch (Exception $e) {
            Log::error('Error in findById', ['error' => $e->getMessage(), 'layer_id' => $id]);
            throw $e;
        }
    }

    public function delete(int $id): void
    {
        DB::beginTransaction();
        try {
            Log::info('Deleting layer', ['layer_id' => $id]);

            $eloquentLayer = EloquentLayer::find($id);
            if (!$eloquentLayer) {
                Log::warning('Layer not found for deletion', ['layer_id' => $id]);
                return;
            }

            $eloquentLayer->delete();
            DB::commit();

            Log::info('Layer deleted successfully', ['layer_id' => $id]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in delete', ['error' => $e->getMessage(), 'layer_id' => $id]);
            throw $e;
        }
    }

    public function create(array $data): Layer
    {
        DB::beginTransaction();
        try {
            Log::info('Creating layer', ['data' => $data]);

             // Habilitar captura de query
                DB::enableQueryLog();

                // Criar a camada
                $eloquentLayer = EloquentLayer::create($data);
                Log::info('Eloequnt', ['data' => $eloquentLayer]);
                // Capturar a query executada
                $queries = DB::getQueryLog();
                Log::info('Query executada no banco', ['queries' => $queries]);

                DB::commit();;
                    

            return $this->mapToDomain($eloquentLayer);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in create', ['error' => $e->getMessage(), 'data' => $data]);
            throw $e;
        }
    }

    public function update(Layer $layer): void
    {
        DB::beginTransaction();
        try {
            Log::info('Updating layer', ['layer_id' => $layer->getId()]);

            $eloquentLayer = EloquentLayer::find($layer->getId());
            if (!$eloquentLayer) {
                Log::warning('Layer not found for update', ['layer_id' => $layer->getId()]);
                return;
            }

            $eloquentLayer->fill([
                'name' => $layer->getName(),
                'layer_name' => $layer->getLayerName(),
                'crs' => $layer->getCrs(),
                'legend_url' => $layer->getLegendUrl(),
                'type' => $layer->getType(),
                'description' => $layer->getDescription(),
                'order' => $layer->getOrder(),
                'subcategory' => $layer->getSubcategoryId(),
                'image_path' => $layer->getImagePath(),
                'max_scale' => $layer->getMaxScale(),
                'symbol' => $layer->getSymbol(),
                'wms_link_id' => $layer->getWmsLinkId(),
                'isPublic' => $layer->IsPublic(), // Atualiza o campo isPublic
            ])->save();

            DB::commit();
            Log::info('Layer updated successfully', ['layer_id' => $layer->getId()]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error in update', ['error' => $e->getMessage(), 'layer_id' => $layer->getId()]);
            throw $e;
        }
    }

    public function existByName(string $name): bool
    {
        try {
            Log::info('Checking if layer exists', ['name' => $name]);

            $exists = EloquentLayer::where('name', $name)->exists();

            Log::info('Existence check result', ['name' => $name, 'exists' => $exists]);

            return $exists;
        } catch (Exception $e) {
            Log::error('Error in existByName', ['error' => $e->getMessage(), 'name' => $name]);
            throw $e;
        }
    }

    public function getAllBySubcategoryId(int $subcategoryId): array
    {
        $layers = EloquentLayer::where('subcategory', $subcategoryId)->get();

        return $layers->map(function ($layer) {
            return $this->mapToDomain($layer);
        })->toArray();
    }

    public function getAllByWmsLinkId(int $wmsLinkId): array
    {
        $layers = EloquentLayer::where('wms_link_id', $wmsLinkId)->get();

        return $layers->map(function ($layer) {
            return $this->mapToDomain($layer);
        })->toArray();
    }
}
