<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWmsLinkIdToLayersTable extends Migration
{
    public function up()
    {
        Schema::table('layers', function (Blueprint $table) {
            // Adiciona a coluna wms_link_id como chave estrangeira
            $table->unsignedBigInteger('wms_link_id')->nullable(); // Permite null, caso necessário
            $table->foreign('wms_link_id')->references('id')->on('wms_links')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('layers', function (Blueprint $table) {
            // Remove a chave estrangeira e a coluna
            $table->dropForeign(['wms_link_id']);
            $table->dropColumn('wms_link_id');
        });
    }
}
