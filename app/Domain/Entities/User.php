<?php

namespace App\Domain\Entities;

class User
{
    private string $id;
    private string $name;
    private string $email;
    private string $login;
    private string $password;
    private string $profileId;

    public function __construct(string $id, string $name, string $email, string $login, string $password, string $profileId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->login = $login;
        $this->password = $password;
        $this->profileId = $profileId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getProfileId(): string
    {
        return $this->profileId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }
    public function setProfileId(string $profileId): void
    {
        $this->profileId = $profileId;
    }
}
