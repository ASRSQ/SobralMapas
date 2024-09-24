<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Category;
use App\Domain\Entities\Layer;
use App\Domain\Entities\Subcategory;
use App\Domain\Repositories\ICategoryRepository;
use App\Infrastructure\Models\Category as EloquentCategory;

class EloquentCategoryRepository implements ICategoryRepository
{
    public function findById(int $id): ?Category
    {
        $category = EloquentCategory::find($id);
        if (!$category) {
            return null;
        }

        return new Category($category->id, $category->name);
    }

    public function create(string $name): void
    {
        // Criação de uma nova categoria
        $eloquentCategory = new EloquentCategory();
        $eloquentCategory->name = $name;
        // Defina outros campos, se necessário
        $eloquentCategory->save();
    }

    public function update(Category $category): void
    {
        $eloquentCategory = EloquentCategory::find($category->getId());
        if ($eloquentCategory) {
            $eloquentCategory->name = $category->getName();
            $eloquentCategory->save();
        }
    }

    public function delete(int $id): void
    {
        $eloquentCategory = EloquentCategory::find($id);

        if ($eloquentCategory) {
            $eloquentCategory->delete();
        }
    }

    public function getCategoriesByTerm(string $searchTerm): array
    {
        $categories = EloquentCategory::with(['subcategories.layers'])
            ->where('name', 'like', '%' . $searchTerm . '%')
            ->orWhereHas('subcategories', function ($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('layers', function ($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%');
                    });
            })
            ->get();

        return $categories->toArray();
    }

    public function getAllCategories(): array
    {
        $categories = EloquentCategory::all();

        return $categories->map(fn($category) => new Category(
            $category->id,
            $category->name
        ))->toArray();
    }

    public function getAllCategoriesWithRelations(): array
    {
        $categories = EloquentCategory::with(['subcategories.layers'])->get();

        return $categories->map(function ($category) {
            $categoryEntity = new Category($category->id, $category->name);

            // Adiciona as subcategorias e camadas associadas
            foreach ($category->subcategories as $subcategory) {
                $subcategoryEntity = new Subcategory(
                    $subcategory->id,
                    $subcategory->name,
                    $category->id
                );

                foreach ($subcategory->layers as $layer) {
                    $layerEntity = new Layer(
                        $layer->id,
                        $layer->name,
                        $layer->layer,
                        $layer->description,
                        $subcategory->id
                    );

                    $subcategoryEntity->addLayer($layerEntity);
                }

                $categoryEntity->addSubcategory($subcategoryEntity);
            }

            return $categoryEntity;
        })->toArray();
    }

    public function existByName(string $name): bool
    {
        return EloquentCategory::where('name', $name)->exists();
    }
}
