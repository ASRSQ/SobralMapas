<?php
namespace App\Domain\Entities;

class Subcategory
{
    private ?int $id;
    private string $name;
    private int $categoryId;
    private array $layers = [];
    private ?Category $category = null;

    public function __construct(?int $id = null, string $name, int $categoryId)
    {
        // Garantindo que o nome não seja vazio
        if (empty($name)) {
            throw new \InvalidArgumentException("O nome da subcategoria não pode ser vazio.");
        }

        // Validando o categoryId (opcional, dependendo do seu modelo de dados)
        if ($categoryId <= 0) {
            throw new \InvalidArgumentException("O ID da categoria deve ser um valor positivo.");
        }

        $this->id = $id;
        $this->name = $name;
        $this->categoryId = $categoryId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    // Setter para o nome
    public function setName(string $name): void
    {
        if (empty($name)) {
            throw new \InvalidArgumentException("O nome da subcategoria não pode ser vazio.");
        }
        $this->name = $name;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }
    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }

    // Método para associar a categoria à subcategoria
    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    // Método para retornar a categoria associada
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    // Método renomeia a subcategoria
    public function updateName(string $newName): void
    {
        $this->setName($newName);
    }

    // Adiciona uma camada ao array de layers
    public function addLayer(Layer $layer): void
    {
        $this->layers[] = $layer;
    }

    // Retorna todas as layers associadas
    public function getLayers(): array
    {
        return $this->layers;
    }

    // Método para obter o nome da categoria associada
    public function getCategoryName(): ?string
    {
        return $this->category ? $this->category->getName() : null;
    }
    
}

