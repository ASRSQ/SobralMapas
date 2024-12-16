<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Layer;

interface ILayerRepository
{
    // Retorna todos os layers
    public function getAllLayers(): array;

    // Encontra um layer pelo ID
    public function findById(int $id): ?Layer;


    // Deleta um layer
    public function delete(int $id): void;

    // Cria um novo layer a partir de um array de dados
    public function create(array $data): Layer;

    // Atualiza um layer existente
    public function update(Layer $layer): void;

    // Verifica se um layer existe pelo nome
    public function existByName(string $name): bool;
}
