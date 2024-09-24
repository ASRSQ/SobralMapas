<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Layer;

interface ILayerRepository
{
    public function getAll(): array;
    public function findById(string $id): ?Layer;
    public function save(Layer $layer): void;
    public function delete(Layer $layer): void;
}
