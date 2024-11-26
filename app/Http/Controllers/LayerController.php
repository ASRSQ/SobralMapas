<?php

namespace App\Http\Controllers;

use App\Application\Services\LayerService;
use App\Domain\Entities\Layer;
use Illuminate\Http\Request;

class LayerController extends Controller
{
    protected $layerService;

    public function __construct(LayerService $layerService)
    {
        $this->layerService = $layerService;
    }

    // Exibe todas as camadas
    public function index()
    {
        $layers = $this->layerService->getAll();
        return view('admin.layers', compact('layers'));
    }

    // Cria uma nova camada
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'layer_name' => 'required|string',
            'description' => 'nullable|string',
            'subcategory_id' => 'required|exists:subcategories,id',
            'image_path' => 'nullable|string',
            'max_scale' => 'nullable|numeric',
            'symbol' => 'nullable|string',
        ]);

        $layer = $this->layerService->create($data);

        return redirect()->route('admin.layers')->with('success', 'Camada criada com sucesso!');
    }

    // Atualiza uma camada existente
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'layer_name' => 'required|string',
            'description' => 'nullable|string',
            'subcategory_id' => 'required|exists:subcategories,id',
            'image_path' => 'nullable|string',
            'max_scale' => 'nullable|numeric',
            'symbol' => 'nullable|string',
        ]);

        $layer = $this->layerService->findById($id);
        if (!$layer) {
            return redirect()->route('admin.layers')->with('error', 'Layer não encontrado!');
        }

        $layer = new Layer($data);
        $this->layerService->update($layer);

        return redirect()->route('admin.layers')->with('success', 'Camada atualizada com sucesso!');
    }

    // Deleta uma camada
    public function destroy($id)
    {
        $layer = $this->layerService->findById($id);
        if (!$layer) {
            return redirect()->route('admin.layers')->with('error', 'Layer não encontrado!');
        }

        $this->layerService->delete($layer);

        return redirect()->route('admin.layers')->with('success', 'Camada deletada com sucesso!');
    }
}
