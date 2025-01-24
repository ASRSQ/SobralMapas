<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Profile;

interface IProfileRepository
{
    public function getAll(): array;
    public function findById(string $id): ?Profile;
    public function save(Profile $profile): void;
    public function update(Profile $profile): void;
    public function delete(string $id): void;
}
