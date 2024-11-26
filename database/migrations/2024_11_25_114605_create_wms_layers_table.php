<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWmsLayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wms_layers', function (Blueprint $table) {
        $table->id();
        $table->foreignId('wms_link_id')->constrained('wms_links')->onDelete('cascade'); // Referência à tabela 'wms_links'
        $table->string('layer_name');
        $table->string('crs')->nullable();
        $table->text('formats')->nullable();
        $table->text('description')->nullable();
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
        Schema::dropIfExists('wms_layers');
    }
}
