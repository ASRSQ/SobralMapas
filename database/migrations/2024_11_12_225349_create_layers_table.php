<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layers', function (Blueprint $table) {
        $table->id();
            $table->string('name');            // Nome da camada
            $table->string('layer_name');       // Nome único do layer no Geoserver (layerName)
            $table->string('crs');              // Sistema de Referência de Coordenadas (CRS)
            $table->string('legend_url')->nullable();  // URL da legenda (Legend URL)
            $table->enum('type', ['WMS', 'WFS']);  // Tipo de serviço (WMS/WFS)
            $table->text('description')->nullable(); // Descrição da camada (Descricao)
            $table->integer('order')->default(0);  // Ordem para exibição
            $table->unsignedBigInteger('subcategory'); // Chave estrangeira para a tabela `subcategories`
            $table->string('image_path')->nullable(); // Caminho da imagem
            $table->timestamps();

            // Definindo a chave estrangeira
            $table->foreign('subcategory')
                ->references('id')              // Campo referenciado na tabela `subcategories`
                ->on('subcategories')           // Tabela com a qual estamos fazendo a relação
                ->onDelete('cascade');          // Caso a subcategoria seja deletada, todas as camadas associadas a ela serão deletadas
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
    }
}
