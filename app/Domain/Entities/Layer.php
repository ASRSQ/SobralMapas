<?php

namespace App\Domain\Entities;

class Layer
{
    private int $id;
    private string $name;
    private string $layer;
    private string $description;
    private int $subcategoryId;

    public function __construct(
        int $id,
        string $name,
        string $layer,
        string $description,
        int $subcategoryId
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->layer = $layer;
        $this->description = $description;
        $this->subcategoryId = $subcategoryId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLayer(): string
    {
        return $this->layer;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSubcategoryId(): string
    {
        return $this->subcategoryId;
    }

    public function updateLayerDetails(string $name, string $layer, string $description): void
    {
        $this->name = $name;
        $this->layer = $layer;
        $this->description = $description;
    }
}
