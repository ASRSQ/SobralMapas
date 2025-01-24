<?php
namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\IProfileRepository;
use App\Domain\Entities\Profile;
use App\Infrastructure\Models\Profile as EloquentProfile;

class EloquentProfileRepository implements IProfileRepository
{
    public function getAll(): array
    {
        return EloquentProfile::all()->map(function ($eloquentProfile) {
            return new Profile(
                $eloquentProfile->id,
                $eloquentProfile->nome
            );
        })->toArray();
    }

    public function findById(string $id): ?Profile
    {
        $eloquentProfile = EloquentProfile::find($id);
        if (!$eloquentProfile) {
            return null;
        }

        return new Profile(
            $eloquentProfile->id,
            $eloquentProfile->nome
        );
    }

    public function save(Profile $profile): void
    {
        $eloquentProfile = new EloquentProfile();
        $eloquentProfile->nome = $profile->getName();
        $eloquentProfile->save();
    }

    public function update(Profile $profile): void
    {
        $eloquentProfile = EloquentProfile::find($profile->getId());
        if (!$eloquentProfile) {
            throw new \Exception("Perfil não encontrado.");
        }

        $eloquentProfile->nome = $profile->getName();
        $eloquentProfile->save();
    }

    public function delete(string $id): void
    {
        $eloquentProfile = EloquentProfile::find($id);
        if ($eloquentProfile) {
            $eloquentProfile->delete();
        }
    }
}
