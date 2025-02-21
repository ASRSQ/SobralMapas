<?php

namespace App\Http\Controllers;

use App\Application\Services\LayerService;
use App\Application\Services\WmsService;
use App\Application\Services\SubcategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LayerController extends Controller
{
    protected $layerService;
    protected $wmsService;
    protected $subcategoryService;

    public function __construct(LayerService $layerService, WmsService $wmsService, SubcategoryService $subcategoryService)
    {
        $this->layerService = $layerService;
        $this->wmsService = $wmsService;
        $this->subcategoryService = $subcategoryService;
    }

    // Exibe todas as camadas
    public function index()
    {
        Log::info('Accessed LayerController@index');

        try {
            $subcategories = $this->subcategoryService->getAll();
            $layers = $this->layerService->getAll();
            $wmsLinks = $this->wmsService->getAllWmsLinks();

            return view('admin.layers', compact('layers', 'wmsLinks', 'subcategories'));
        } catch (\Exception $e) {
            Log::error('Error accessing LayerController@index', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Error fetching layers'], 500);
        }
    }

    public function store(Request $request)
    {
       // Logando todos os dados do request e o tipo de 'is_public'
    Log::info('Accessed LayerController@store', [
        'request_data' => $request->all(),
        'is_public_type' => gettype($request->input('is_public')),
    ]);
    
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
                'wms_link_id' => 'required|integer',
                'is_public' => 'nullable|integer|in:0,1', // Alterado para validar como inteiro
            ]);
    
            // Verifica se o layer já existe
            if ($this->layerService->existsByLayerName($request->input('name'))) {
                return redirect()->route('admin.layers.index')->with('error', 'A camada já existe.');
            }
            // Criação do layer
            $this->layerService->create($request->all());
    
            return redirect()->route('admin.layers.index')->with('success', 'Camada criada com sucesso.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->route('admin.layers.index')->with('error', 'Erro ao criar a camada.');
        }
    }
    
    

    // Método para atualizar um layer
    public function update(Request $request, $id)
    {
        $id = (int) $id; // Garantir que o ID seja um inteiro
        Log::info('Accessed LayerController@update', [
            'layer_id' => $id, 
            'type' => gettype($id), 
            'request_data' => $request->all(),
            'subcategory' => $request->input('subcategory')
        ]);
    
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
                'wms_link_id' => 'required|integer',
                'is_public' => 'nullable|integer|in:0,1', // Alterado para validar como inteiro
            ]);
    
            $this->layerService->update($id, $request->all());
    
            Log::info('Layer updated successfully', ['layer_id' => $id]);
    
            return redirect()->route('admin.layers.index')->with('success', 'Camada atualizada com sucesso.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error in LayerController@update', [
                'error' => $e->getMessage(),
                'layer_id' => $id,
                'request_data' => $request->all(),
            ]);
    
            return redirect()->route('admin.layers.index')->with('error', 'Erro ao atualizar a camada.');
        }
    }
    
    

    


   // Método para deletar um layer
public function destroy(int $id)
{
    Log::info('Accessed LayerController@destroy', ['layer_id' => $id]);

    try {
        $this->layerService->delete($id);

        Log::info('Layer deleted successfully', ['layer_id' => $id]);

        return redirect()->route('admin.layers.index')
            ->with('success', 'Camada deletada com sucesso.');
    } catch (\Exception $e) {
        Log::error('Error in LayerController@destroy', ['error' => $e->getMessage(), 'layer_id' => $id]);
        return redirect()->route('admin.layers.index')
            ->with('error', 'Erro ao deletar camada: ' . $e->getMessage());
    }
}

}
