<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Models\Profile; // Certifique-se de que o caminho está correto

class ProfileSeeder extends Seeder
{
    public function run()
    {
        Profile::create(['nome' => 'Administrador']);
        Profile::create(['nome' => 'Agente']);
        Profile::create(['nome' => 'Visitante']);
    }
}
