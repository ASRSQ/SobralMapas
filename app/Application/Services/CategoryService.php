<?php

namespace App\Application\Services;


use App\Domain\Repositories\ICategoryRepository;
use Exception;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(
        ICategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }


    public function getAllWithRelations()
    {
        return $this->categoryRepository->getAllCategoriesWithRelations();
    }

    public function getCategoriesByTerm(string $searchTerm = null)
    {
        return $this->categoryRepository->getCategoriesByTerm($searchTerm);
    }

    // CRUD
    public function getAll()
    {
        return $this->categoryRepository->getAllCategories();
    }

    public function findCategoryById(int $categoryId)
    {
        return $this->categoryRepository->findById($categoryId);
    }

    public function createCategory(array $data)
    {
        if (empty($data['name']) || !is_string($data['name'])) {
            throw new \InvalidArgumentException('O nome da categoria é obrigatorio e deve ser um texto');
        }

        //verifica se a categoria ja existe
        if ($this->categoryRepository->existByName($data['name'])) {
            throw new \InvalidArgumentException('uma categoria com esse nome já existe.');
        }

        // criacao e persistencia da entidade Category
        $this->categoryRepository->create($data['name']);
    }

    public function updateCategory(int $id, array $data)
    {
        //validacao dos dados

        if (empty($data['name']) || !is_string($data['name'])) {
            throw new \InvalidArgumentException('O nome da categoria é obrigatório e não pode iniciar com números.');
        }

        // Verifica se a categoria existe
        $category = $this->categoryRepository->findById($id);
        if (!$category) {
            throw new Exception('Categoria não encontrada.');
        }

        // verifica se o nome ja esta em uso por outra categoria
        if ($this->categoryRepository->existByName($data['name'])) {
            throw new Exception('Uma categoria com esse nome já existe.');
        }

        // Atualiza a entidade de dominio Category
        $category->rename($data['name']);

        //persistencia no banco
        $this->categoryRepository->update($category);
    }

    public function deleteCategory(int $id)
    {
        $this->categoryRepository->delete($id);
    }
}
