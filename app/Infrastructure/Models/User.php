<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Tabela associada ao modelo
    protected $table = 'users';

    // Campos que podem ser atribuídos em massa
    protected $fillable = ['name', 'email', 'login', 'password', 'profile_id'];

    // Ocultar campos sensíveis ao converter para array/JSON
    protected $hidden = ['password'];

    /**
     * Relacionamento com o modelo Profile
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}

