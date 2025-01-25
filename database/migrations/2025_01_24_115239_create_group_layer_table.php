<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupLayerTable extends Migration
{
    public function up()
    {
        Schema::create('group_layer', function (Blueprint $table) {
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('layer_id')->constrained('layers')->onDelete('cascade');
            $table->primary(['group_id', 'layer_id']); // Chave primária composta
        });
    }

    public function down()
    {
        Schema::dropIfExists('group_layer');
    }
}
