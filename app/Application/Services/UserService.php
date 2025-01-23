<?php
namespace App\Application\Services;

use App\Domain\Entities\User;
use App\Domain\Repositories\IUserRepository;
use App\Domain\Repositories\IProfileRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private IUserRepository $userRepository;
    private IProfileRepository $profileRepository;

    public function __construct(IUserRepository $userRepository, IProfileRepository $profileRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }

    /**
     * Retorna todos os usuários
     *
     * @return array
     */
    public function getAllUsers(): array
    {
        return $this->userRepository->getAll();
    }

    /**
     * Retorna todos os perfis
     *
     * @return array
     */
    public function getAllProfiles(): array
    {
        return $this->profileRepository->getAll();
    }

    /**
     * Cria um novo usuário
     *
     * @param string $name
     * @param string $email
     * @param string $login
     * @param string $password
     * @param string $profileId
     * @return User
     */
    public function createUser(string $name, string $email, string $login, string $password, string $profileId): User
    {
        // Valida se o perfil existe
        $profile = $this->profileRepository->findById($profileId);
        if (!$profile) {
            throw new \Exception("Perfil não encontrado.");
        }

        // Cria a entidade de domínio User
        $hashedPassword = Hash::make($password);
        $user = new User(uniqid(), $name, $email, $login, $hashedPassword, $profileId);

        // Salva o usuário no repositório
        $this->userRepository->save($user);

        return $user;
    }

    /**
     * Atualiza um usuário existente
     *
     * @param string $id
     * @param string $name
     * @param string $email
     * @param string $login
     * @param string|null $password
     * @param string $profileId
     * @return void
     */
    public function updateUser(string $id, string $name, string $email, string $login, ?string $password, string $profileId): void
    {
         // Busca o usuário no repositório
         $user = $this->userRepository->findById($id);

         if (!$user) {
             throw new \Exception('Usuário não encontrado.');
         }
 
         // Atualiza os dados do usuário
         $user->setName($name);
         $user->setEmail($email);
         $user->setLogin($login);
 
         if ($password !== null && !Hash::check($password, $user->getPassword())) {
             $user->setPassword(Hash::make($password)); // Atualiza a senha apenas se for diferente
         }
 
         $user->setProfileId($profileId);
 
         // Salva o usuário atualizado no repositório
         $this->userRepository->update($user);
    }

    /**
     * Exclui um usuário
     *
     * @param string $id
     * @return void
     */
    public function deleteUser(string $id): void
    {
        $user = $this->userRepository->findById($id);
        if (!$user) {
            throw new \Exception("Usuário não encontrado.");
        }

        $this->userRepository->delete($id);
    }
    public function findUserById(string $id): ?User
    {
        return $this->userRepository->findById($id);
    }
}
