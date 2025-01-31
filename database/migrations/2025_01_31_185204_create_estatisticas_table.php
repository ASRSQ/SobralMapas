<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstatisticasTable extends Migration
{
    public function up() {
        Schema::create('estatisticas', function (Blueprint $table) {
            $table->id();
            $table->string('ip_usuario'); // Armazena o IP do usuário
            $table->json('mapas_selecionados'); // JSON com os mapas e contagens
            $table->integer('tempo_total')->default(0); // Tempo total em segundos
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('estatisticas');
    }
}
