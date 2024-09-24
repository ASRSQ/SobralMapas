<?php

namespace App\Application\Services;


use App\Domain\Repositories\ILayerRepository;

class LayerService
{
    protected $layerRepository;

    public function __construct(
        ILayerRepository $layerRepository
    ) {
        $this->layerRepository = $layerRepository;
    }


    public function getAll()
    {
        $layers =  $this->layerRepository->getAll();

        return array_map(function ($layer) {
            return [
                'id' => $layer->getId(),
                'name' => $layer->getName(),
                'layer' => $layer->getLayer(),
                'description' => $layer->getDescription(),
                'subcategory_id' => $layer->getSubcategoryId()
            ];
        }, $layers);
    }
}
