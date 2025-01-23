<?php
namespace App\Application\Services;

use App\Domain\Repositories\IProfileRepository;
use App\Domain\Entities\Profile;

class ProfileService
{
    private IProfileRepository $profileRepository;

    public function __construct(IProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getAllProfiles(): array
    {
        return $this->profileRepository->getAll();
    }

    public function createProfile(string $name): Profile
    {
        $profile = new Profile(uniqid(), $name);
        $this->profileRepository->save($profile);

        return $profile;
    }

    public function updateProfile(string $id, string $name): void
    {
        $profile = $this->profileRepository->findById($id);
        if (!$profile) {
            throw new \Exception("Perfil não encontrado.");
        }

        $profile->setName($name);
        $this->profileRepository->update($profile);
    }

    public function deleteProfile(string $id): void
    {
        $this->profileRepository->delete($id);
    }
}
