<?php
namespace App\Application\Services;

use App\Domain\Repositories\ISubcategoryRepository;
use App\Domain\Repositories\ICategoryRepository;
use App\Infrastructure\Models\Subcategory as EloquentSubcategory;
use App\Domain\Entities\Subcategory;
use Illuminate\Support\Facades\Log;
use Exception;

class SubcategoryService
{
    protected $subcategoryRepository;
    protected $categoryRepository; // Adicionada a propriedade para o repositório de categorias

    // Injetando tanto o repositório de subcategorias quanto o de categorias
    public function __construct(ISubcategoryRepository $subcategoryRepository, ICategoryRepository $categoryRepository)
    {
        $this->subcategoryRepository = $subcategoryRepository;
        $this->categoryRepository = $categoryRepository; // Atribuindo o repositório de categorias
    }

    public function getAll()
    {
        return $this->subcategoryRepository->getAll();
    }

    public function findSubcategoryById(int $subcategoryId)
    {
        return $this->subcategoryRepository->findById($subcategoryId);
    }

    public function getSubcategoriesByCategoryId(int $categoryId)
    {
        return $this->subcategoryRepository->getByCategoryId($categoryId);
    }

    public function createSubcategory(array $data)
    {
        if (empty($data['name']) || !is_string($data['name'])) {
            throw new \InvalidArgumentException('O nome da subcategoria é obrigatório e deve ser um texto');
        }
    
        if (empty($data['category_id']) || !is_numeric($data['category_id'])) {  // Alterado de is_int para is_numeric
            throw new \InvalidArgumentException('A categoria associada é obrigatória e deve ser um número inteiro');
        }
    
        // Verifica se a subcategoria já existe para a categoria
        if ($this->subcategoryRepository->existByNameAndCategoryId($data['name'], (int)$data['category_id'])) {
            throw new \InvalidArgumentException('Uma subcategoria com esse nome já existe nesta categoria.');
        }
    
        // Criação e persistência da entidade Subcategory
        $subcategory = new Subcategory(null, $data['name'], (int)$data['category_id']);
        $this->subcategoryRepository->save($subcategory);
    }

    public function updateSubcategory($id, $data)
    {
        // Encontra a subcategoria no banco de dados usando o ID
        $eloquentSubcategory = EloquentSubcategory::find($id);
    
        if ($eloquentSubcategory) {
            // Criar a entidade Subcategory a partir do eloquentSubcategory
            $subcategory = new Subcategory(null,$eloquentSubcategory->name, $eloquentSubcategory->category_id);
    
            // Atualiza os campos da subcategoria usando os setters da entidade
            $subcategory->setName($data['name']);
            $subcategory->setCategoryId($data['category_id']);
    
            // Atualiza os dados no banco de dados
            $eloquentSubcategory->name = $subcategory->getName(); // Usando o getter para 'name'
            $eloquentSubcategory->category_id = $subcategory->getCategoryId(); // Usando o getter para 'category_id'
    
            // Salva as alterações no banco de dados
            $eloquentSubcategory->save();
        } else {
            // Lança uma exceção se a subcategoria não for encontrada
            throw new \Exception('Subcategoria não encontrada para o ID: ' . $id);
        }
    }
    

    public function deleteSubcategory(int $id)
    {
        $this->subcategoryRepository->delete($id);
    }
}
