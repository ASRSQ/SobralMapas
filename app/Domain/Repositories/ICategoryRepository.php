<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Category;

interface ICategoryRepository
{
    public function getAllCategories(): array;
    public function getAllCategoriesWithRelations(): array;
    public function findById(int $id): ?Category;
    public function create(string $name): void;
    public function update(Category $category): void;
    public function delete(int $id): void;
    public function getCategoriesByTerm(string $searchTerm): array;
    public function existByName(string $name): bool;
}
