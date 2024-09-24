<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesAndLayersTables extends Migration
{
      /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Criar a tabela categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Criar a tabela layers com chave estrangeira para categories
        Schema::create('layers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('layer');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layers');
        Schema::dropIfExists('categories');
    }
}
