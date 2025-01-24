<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // Tabela associada ao modelo
    protected $table = 'profiles';

    // Campos que podem ser atribuídos em massa
    protected $fillable = ['nome'];

    /**
     * Relacionamento com o modelo User
     */
    public function users()
    {
        return $this->hasMany(User::class, 'profile_id');
    }
}
