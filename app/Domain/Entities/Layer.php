<?php

namespace App\Domain\Entities;

class Layer
{
    protected $id;
    protected $name;
    protected $layer_name;
    protected $crs;
    protected $legend_url;
    protected $type;
    protected $description;
    protected $order;
    protected $subcategory;
    protected $image_path;
    protected $max_scale;
    protected $symbol;

    public function __construct(
        int $id,
        string $name,
        string $layer_name,
        string $crs,
        string $legend_url,
        string $type,
        string $description,
        int $order,
        $subcategory,
        string $image_path,
        int $max_scale,
        string $symbol
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->layer_name = $layer_name;
        $this->crs = $crs;
        $this->legend_url = $legend_url;
        $this->type = $type;
        $this->description = $description;
        $this->order = $order;
        $this->subcategory = $subcategory;
        $this->image_path = $image_path;
        $this->max_scale = $max_scale;
        $this->symbol = $symbol;
    }

    // Métodos getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLayerName(): string
    {
        return $this->layer_name;
    }

    public function getCrs(): string
    {
        return $this->crs;
    }

    public function getLegendUrl(): string
    {
        return $this->legend_url;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getOrder(): int
    {
        return $this->order;
    }

    public function getSubcategory()
    {
        return $this->subcategory;  // Pode ser uma instância de Subcategory
    }

    public function getImagePath(): string
    {
        return $this->image_path;
    }

    public function getMaxScale(): int
    {
        return $this->max_scale;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
}
