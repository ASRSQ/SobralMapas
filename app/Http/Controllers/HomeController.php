<?php

namespace App\Http\Controllers;

use App\Http\controllers\Controller;
use App\Application\Services\CategoryService;
use App\Application\Services\LayerService;
use App\Application\Services\GeoServerService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private CategoryService $categoryService;
    private LayerService $layerService;
    private GeoServerService $geoServerService;

    public function __construct(
        CategoryService $categoryService,
        LayerService $layerService,
        GeoServerService $geoServerService
    ) {
        $this->categoryService = $categoryService;
        $this->layerService = $layerService;
        $this->geoServerService = $geoServerService; 
    }

    public function index()
    {
        $categories = $this->categoryService->getAllWithRelations();
        $layers = $this->layerService->getAll();
        return view('home.index', compact('categories', 'layers'));
    }

    public function tile()
    {
        return view('home.tile');
    }

    public function coord()
    {
        // Obter as camadas do GeoServer usando o serviço
        $response = $this->geoServerService->getCapabilities();

        // Verificar se a requisição foi bem-sucedida
        if ($response->successful()) {
            // Carregar o XML de resposta
            $xml = simplexml_load_string($response->body());

            // Buscar todas as camadas no XML (Capability > Layer > Layer)
            $layers = $xml->Capability->Layer->Layer ?? [];

            // Extrair nome e título de cada camada
            $layersData = [];
            foreach ($layers as $layer) {
                $layerName = (string) $layer->Name;
                $layerTitle = (string) ($layer->Title ?? 'Sem título');
                $layersData[] = ['name' => $layerName, 'title' => $layerTitle];
            }

            // Passar as camadas para a view
            return view('home.coord', compact('layersData'));
        } else {
            // Tratar o erro e passar uma mensagem para a view
            return view('home.coord', ['error' => 'Erro ao carregar as camadas do GeoServer']);
        }
    }

    public function search(Request $request)
    {
        // $searchTerm = $request->input('search');
        // $categories = $this->categoryFilterByTermUseCase->execute($searchTerm);

        // return response()->json($categories);
    }
}
