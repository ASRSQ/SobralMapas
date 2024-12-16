<?php

namespace App\Http\Controllers;

use App\Application\Services\LayerService;
use App\Application\Services\WmsService;
use App\Application\Services\SubcategoryService;
use App\Domain\Entities\Layer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Importando o Log

class LayerController extends Controller
{
    protected $layerService;
    protected $wmsService;
    protected $subcategory;

    public function __construct(LayerService $layerService, WmsService $wmsService, SubcategoryService $subcategory)
    {
        $this->subcategory  = $subcategory;
        $this->layerService = $layerService;
        $this->wmsService = $wmsService; // Injeta o WmsService
    }

    // Exibe todas as camadas
    public function index()
    {
        Log::info('Accessed LayerController@index'); // Log indicando acesso ao método

        try {
            $subcategories = $this->subcategory->getAll();
            $layers = $this->layerService->getAll();
            $wmsLinks = $this->wmsService->getAllWmsLinks();

            return view('admin.layers', compact('layers', 'wmsLinks', 'subcategories'));
        } catch (\Exception $e) {
            Log::error('Error accessing LayerController@index', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error fetching layers'], 500);
        }
    }

    // Método para criar um novo layer
    public function store(Request $request)
    {
        Log::info('Accessed LayerController@store', ['request_data' => $request->all()]); // Log de dados recebidos na requisição

        // Validação de dados de entrada (exemplo simples)
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'layer_name' => 'required|string|max:255',
                'crs' => 'nullable|string|max:255',
                'legend_url' => 'nullable|string|max:255',
                'type' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'order' => 'nullable|integer',
                'subcategory' => 'nullable|integer',
                'image_path' => 'nullable|string|max:255',
                'max_scale' => 'nullable|numeric',
                'symbol' => 'nullable|string|max:255',
            ]);

            // Criação do layer
            $layer = $this->layerService->create($request->all());

            Log::info('Layer created successfully', ['layer_id' => $layer->getId()]); // Log indicando sucesso na criação

            return response()->json($layer, 201);
        } catch (\Exception $e) {
            Log::error('Error in LayerController@store', ['error' => $e->getMessage(), 'request_data' => $request->all()]);
            return response()->json(['message' => 'Error storing layer'], 500);
        }
    }

    // Método para atualizar um layer
    public function update(Request $request, int $id)
    {
        Log::info('Accessed LayerController@update', ['layer_id' => $id, 'request_data' => $request->all()]); // Log de dados recebidos para atualização

        try {
            // Validação de dados de entrada
            $request->validate([
                'name' => 'required|string|max:255',
                'layer_name' => 'required|string|max:255',
                'crs' => 'nullable|string|max:255',
                'legend_url' => 'nullable|string|max:255',
                'type' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'order' => 'nullable|integer',
                'subcategory' => 'nullable|integer',
                'image_path' => 'nullable|string|max:255',
                'max_scale' => 'nullable|numeric',
                'symbol' => 'nullable|string|max:255',
            ]);

            // Criar a entidade Layer
            $layer = new Layer(
                $id,
                $request->input('name'),
                $request->input('layer_name'),
                $request->input('crs'),
                $request->input('legend_url'),
                $request->input('type'),
                $request->input('description'),
                $request->input('order'),
                $request->input('subcategory'),
                $request->input('image_path'),
                $request->input('max_scale'),
                $request->input('symbol')
            );

            // Atualização do layer
            $this->layerService->update($layer);

            Log::info('Layer updated successfully', ['layer_id' => $id]); // Log indicando sucesso na atualização

            return response()->json(['message' => 'Layer updated successfully']);
        } catch (\Exception $e) {
            Log::error('Error in LayerController@update', ['error' => $e->getMessage(), 'layer_id' => $id, 'request_data' => $request->all()]);
            return response()->json(['message' => 'Error updating layer'], 500);
        }
    }

    // Método para deletar um layer
    public function destroy(int $id)
    {
        Log::info('Accessed LayerController@destroy', ['layer_id' => $id]); // Log indicando que o método delete foi chamado

        try {
            // Deletar o layer
            $this->layerService->delete($id);

            Log::info('Layer deleted successfully', ['layer_id' => $id]); // Log indicando sucesso na exclusão

            return response()->json(['message' => 'Layer deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error in LayerController@destroy', ['error' => $e->getMessage(), 'layer_id' => $id]);
            return response()->json(['message' => 'Error deleting layer'], 500);
        }
    }
}
