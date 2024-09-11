<?php

namespace App\Domain\Entities;

use App\Domain\Entities\Subcategory;

class Category
{
    private int $id;
    private string $name;
    private array $subcategories = [];

    public function __construct(int $id = null, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function rename(string $newName): void
    {
        $this->name = $newName;
    }

    public function addSubcategory(Subcategory $subcategory): void
    {
        $this->subcategories[] = $subcategory;
    }

    public function getSubcategories(): array
    {
        return $this->subcategories;
    }
}
