<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Layer;

interface ILayerRepository
{
    /**
     * Retorna todos os layers.
     *
     * @return array
     */
    public function getAllLayers(): array;

    /**
     * Encontra um layer pelo ID.
     *
     * @param int $id
     * @return Layer|null
     */
    public function findById(int $id): ?Layer;

    /**
     * Deleta um layer.
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Cria um novo layer a partir de um array de dados.
     *
     * @param array $data
     * @return Layer
     */
    public function create(array $data): Layer;

    /**
     * Atualiza um layer existente.
     *
     * @param Layer $layer
     * @return void
     */
    public function update(Layer $layer): void;

    /**
     * Verifica se um layer existe pelo nome.
     *
     * @param string $name
     * @return bool
     */
    public function existByName(string $name): bool;

    /**
     * Retorna todos os layers associados a uma subcategoria especificada.
     *
     * @param int $subcategoryId
     * @return array
     */
    public function getAllBySubcategoryId(int $subcategoryId): array;

    /**
     * Retorna todos os layers associados a um WMS Link especificado.
     *
     * @param int $wmsLinkId
     * @return array
     */
    public function getAllByWmsLinkId(int $wmsLinkId): array;
}
