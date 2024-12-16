<?php
namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Subcategory;
use App\Domain\Repositories\ISubcategoryRepository;
use App\Infrastructure\Models\Subcategory as EloquentSubcategory;
use App\Domain\Entities\Category;

class EloquentSubcategoryRepository implements ISubcategoryRepository
{
    /**
     * Find a subcategory by its ID.
     *
     * @param string $id
     * @return Subcategory|null
     */
    public function findById(string $id): ?Subcategory
    {
        $subcategory = EloquentSubcategory::find($id);

        if (!$subcategory) {
            return null;
        }

        return new Subcategory($subcategory->id, $subcategory->name, $subcategory->category_id);
    }

    /**
     * Save a new subcategory.
     *
     * @param Subcategory $subcategory
     * @return void
     */
    public function save(Subcategory $subcategory): void
    {
        $eloquentSubcategory = new EloquentSubcategory();
        $eloquentSubcategory->name = $subcategory->getName();
        $eloquentSubcategory->category_id = $subcategory->getCategoryId();
        $eloquentSubcategory->save();
    }

    /**
     * Delete a subcategory by its ID.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $eloquentSubcategory = EloquentSubcategory::find($id);

        if ($eloquentSubcategory) {
            $eloquentSubcategory->delete();
        }
    }

    /**
     * Get all subcategories with their categories.
     *
     * @return array
     */
    public function getAll(): array
    {
        $subcategories = EloquentSubcategory::with('category')->get();

        return $subcategories->map(function ($subcategory) {
            // Criação da entidade Subcategory e associação com a categoria
            $subcat = new Subcategory(
                $subcategory->id,
                $subcategory->name,
                $subcategory->category_id
            );

            // Associa a categoria à subcategoria
            $subcat->setCategory(new Category(
                $subcategory->category->id,
                $subcategory->category->name
            ));

            return $subcat;
        })->toArray();
    }

    /**
     * Get all subcategories by category ID.
     *
     * @param int $categoryId
     * @return array
     */
    public function getAllByCategoryId(int $categoryId): array
    {
        $subcategories = EloquentSubcategory::where('category_id', $categoryId)->get();

        return $subcategories->map(function ($subcategory) {
            return new Subcategory($subcategory->id, $subcategory->name, $subcategory->category_id);
        })->toArray();
    }

    /**
     * Check if a subcategory exists by name.
     *
     * @param string $name
     * @return bool
     */
    public function existByName(string $name): bool
    {
        return EloquentSubcategory::where('name', $name)->exists();
    }

    /**
     * Check if a subcategory exists by name and category ID.
     *
     * @param string $name
     * @param int $categoryId
     * @return bool
     */
    public function existByNameAndCategoryId(string $name, int $categoryId): bool
    {
        return EloquentSubcategory::where('name', $name)
            ->where('category_id', $categoryId)
            ->exists();
    }

    /**
     * Update an existing subcategory.
     *
     * @param Subcategory $subcategory
     * @return void
     */
   public function update(Subcategory $subcategory): void
{
    // Log: Iniciando a busca pela subcategoria no banco de dados
    Log::info('Buscando subcategoria no banco de dados', ['id' => $subcategory->getId()]);

    $eloquentSubcategory = EloquentSubcategory::find($subcategory->getId());

    // Verifica se a subcategoria foi encontrada
    if (!$eloquentSubcategory) {
        Log::error('Subcategoria não encontrada', ['id' => $subcategory->getId()]);
        throw new \Exception('Subcategoria não encontrada para o ID: ' . $subcategory->getId());
    }

    // Log: Subcategoria encontrada, atualizando os dados
    Log::info('Subcategoria encontrada, atualizando dados', [
        'id' => $subcategory->getId(),
        'current_name' => $eloquentSubcategory->name,
        'new_name' => $subcategory->getName(),
        'current_category_id' => $eloquentSubcategory->category_id,
        'new_category_id' => $subcategory->getCategoryId()
    ]);

    // Atualiza os campos da subcategoria
    $eloquentSubcategory->name = $subcategory->getName();  // Nome atualizado
    $eloquentSubcategory->category_id = $subcategory->getCategoryId();  // ID da categoria atualizado

    // Log: Salvando alterações no banco de dados
    Log::info('Salvando alterações na subcategoria', [
        'id' => $eloquentSubcategory->id,
        'name' => $eloquentSubcategory->name,
        'category_id' => $eloquentSubcategory->category_id
    ]);

    // Salva as alterações no banco de dados
    $eloquentSubcategory->save();

    // Log: Alterações salvas com sucesso
    Log::info('Alterações salvas com sucesso', ['id' => $eloquentSubcategory->id]);
}
public static function getNameById(int $id): ?string
{
    $subcategory = EloquentSubcategory::find($id); // Usando o modelo Eloquent diretamente
    return $subcategory ? $subcategory->name : null; // Retorna o nome ou null se não encontrado
}


}
