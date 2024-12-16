<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVersionToWmsLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wms_links', function (Blueprint $table) {
            Schema::table('wms_links', function (Blueprint $table) {
                $table->string('version')->nullable()->after('url'); // Substitua 'some_column' pela coluna anterior
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wms_links', function (Blueprint $table) {
            $table->dropColumn('version');
        });
    }
}
