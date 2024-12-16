<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxScaleAndSymbolToLayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('layers', function (Blueprint $table) {
            $table->integer('max_scale')->unsigned()->nullable()->after('updated_at');
            $table->text('symbol')->nullable()->after('max_scale');
        });
    }
    
    public function down()
    {
        Schema::table('layers', function (Blueprint $table) {
            $table->dropColumn(['max_scale', 'symbol']);
        });
    }
}
