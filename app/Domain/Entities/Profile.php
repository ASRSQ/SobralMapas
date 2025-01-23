<?php
namespace App\Domain\Entities;

class Profile
{
    private string $id;
    private string $nome;

    public function __construct(string $id, string $nome)
    {
        $this->id = $id;
        $this->name = $nome;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->name;
    }

    public function setName(string $nome): void
    {
        $this->name = $nome;
    }
}
