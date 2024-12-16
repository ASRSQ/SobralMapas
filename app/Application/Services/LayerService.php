<?php

namespace App\Application\Services;

use App\Domain\Repositories\ILayerRepository;
use App\Domain\Entities\Layer;
use Illuminate\Support\Facades\Log; // Importando o Log
use Exception;

class LayerService
{
    protected $layerRepository;

    public function __construct(ILayerRepository $layerRepository)
    {
        $this->layerRepository = $layerRepository;
    }

    // Método para criar um novo layer
    public function create(array $data): Layer
    {
        try {
            Log::info('Accessed LayerService@create', ['data' => $data]); // Logando os dados recebidos no método

            // Realize aqui as validações de negócios, se necessário
            $layer = $this->layerRepository->create($data);

            Log::info('Layer created successfully', ['layer_id' => $layer->getId()]); // Log indicando que o layer foi criado com sucesso

            return $layer;
        } catch (Exception $e) {
            Log::error('Error creating layer', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'data' => $data
            ]); // Logando o erro

            throw $e; // Re-lançando a exceção para que ela seja tratada em outro nível (Controller, por exemplo)
        }
    }

    // Método para atualizar um layer
    public function update(Layer $layer): void
    {
        try {
            Log::info('Accessed LayerService@update', ['layer_id' => $layer->getId()]); // Logando o ID do layer a ser atualizado

            // Realize aqui as validações de negócios, se necessário
            $this->layerRepository->update($layer);

            Log::info('Layer updated successfully', ['layer_id' => $layer->getId()]); // Log indicando que o layer foi atualizado com sucesso
        } catch (Exception $e) {
            Log::error('Error updating layer', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'layer_id' => $layer->getId()
            ]); // Logando o erro

            throw $e; // Re-lançando a exceção
        }
    }

    // Método para deletar um layer
    public function delete(int $id): void
    {
        try {
            Log::info('Accessed LayerService@delete', ['layer_id' => $id]); // Logando o ID do layer a ser deletado

            // Realize aqui as validações de negócios, se necessário
            $this->layerRepository->delete($id);

            Log::info('Layer deleted successfully', ['layer_id' => $id]); // Log indicando que o layer foi deletado com sucesso
        } catch (Exception $e) {
            Log::error('Error deleting layer', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'layer_id' => $id
            ]); // Logando o erro

            throw $e; // Re-lançando a exceção
        }
    }

    // Método para buscar todos os layers
    public function getAll(): array
    {
        try {
            Log::info('Accessed LayerService@getAll'); // Log indicando que o método getAll foi acessado

            $layers = $this->layerRepository->getAllLayers();

            Log::info('Fetched all layers', ['layers_count' => count($layers)]); // Log indicando o número de layers retornados

            return $layers;
        } catch (Exception $e) {
            Log::error('Error fetching all layers', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]); // Logando o erro

            throw $e; // Re-lançando a exceção
        }
    }
    
}
