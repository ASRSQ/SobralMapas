<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPublicToLayersTable extends Migration
{
    public function up(): void
    {
        Schema::table('layers', function (Blueprint $table) {
            // Adicione o campo isPublic
            $table->boolean('isPublic')->default(false)->after('wms_link_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('layers', function (Blueprint $table) {
            // Remova o campo isPublic
            $table->dropColumn('isPublic');
        });
    }
}
