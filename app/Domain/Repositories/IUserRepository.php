<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface IUserRepository
{
    public function findById(string $id): ?User;

    public function save(User $user): void;

    public function update(User $user): void;

    public function delete(string $id): void;

    public function findByEmail(string $email): ?User;

    public function existsByLogin(string $login): bool;

    public function getAll(): array;
}
