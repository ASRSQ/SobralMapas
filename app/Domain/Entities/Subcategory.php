<?php

namespace App\Domain\Entities;

class Subcategory
{
    private int $id;
    private string $name;
    private int $categoryId;
    private array $layers = [];

    public function __construct(int $id, string $name, int $categoryId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function addLayer(Layer $layer): void
    {
        $this->layers[] = $layer;
    }

    public function getLayers(): array
    {
        return $this->layers;
    }
}
