<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Subcategory;

interface ISubcategoryRepository
{
    public function getAll(): array;
    public function findById(string $id): ?Subcategory;
    public function save(Subcategory $subcategory): void;
    public function delete(int $id): void;
    public function update(Subcategory $subcategory): void;
    public static function getNameById(int $id): ?string;
}
