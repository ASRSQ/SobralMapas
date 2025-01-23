<?php
namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\IUserRepository;
use App\Infrastructure\Models\User as EloquentUser;

class EloquentUserRepository implements IUserRepository
{
    public function findById(string $id): ?User
    {
        $user = EloquentUser::find($id);
        if (!$user) {
            return null;
        }
        return new User($user->id, $user->name, $user->email, $user->login, $user->password, $user->profile_id);
    }

    public function save(User $user): void
    {
        $eloquentUser = new EloquentUser();
        $eloquentUser->name = $user->getName();
        $eloquentUser->email = $user->getEmail();
        $eloquentUser->login = $user->getLogin();
        $eloquentUser->password = $user->getPassword();
        $eloquentUser->profile_id = $user->getProfileId();
        $eloquentUser->save();
    }

    public function update(User $user): void
    {
        $eloquentUser = EloquentUser::find($user->getId());

    if (!$eloquentUser) {
        throw new \Exception('Usuário não encontrado para salvar.');
    }

    $eloquentUser->name = $user->getName();
    $eloquentUser->email = $user->getEmail();
    $eloquentUser->login = $user->getLogin();
    $eloquentUser->password = $user->getPassword();
    $eloquentUser->profile_id = $user->getProfileId();

    $eloquentUser->save();
    }

    public function delete(string $id): void
    {
        $eloquentUser = EloquentUser::find($id);
        if ($eloquentUser) {
            $eloquentUser->delete();
        }
    }

    public function findByEmail(string $email): ?User
    {
        $user = EloquentUser::where('email', $email)->first();
        if (!$user) {
            return null;
        }
        return new User($user->id, $user->name, $user->email, $user->login, $user->password, $user->profile_id);
    }

    public function existsByLogin(string $login): bool
    {
        return EloquentUser::where('login', $login)->exists();
    }

    public function getAll(): array
    {
        return EloquentUser::all()->map(function ($user) {
            return new User($user->id, $user->name, $user->email, $user->login, $user->password, $user->profile_id);
        })->toArray();
    }
}
