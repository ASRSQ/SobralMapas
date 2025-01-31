<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Application\Services\CategoryService;
use App\Application\Services\LayerService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private CategoryService $categoryService;
    private LayerService $layerService;

    public function __construct(
        CategoryService $categoryService,
        LayerService $layerService
    ) {
        $this->categoryService = $categoryService;
        $this->layerService = $layerService;
    }

    public function index()
    {
        // Adicionar lógica apra testar se é pública ou não
        $layers = collect($this->layerService->getPublicLAyers()); // Converte para Collection
        // dd($layers );
        return view('pages.home', compact('layers'));
    }

    public function tile()
    {
        return view('home.tile');
    }

    public function coord()

    {
        $publicteLayers = $this->layerService->getPublicLAyers();
        
        return view('home.coord',compact('publicteLayers'));
    }

    public function search(Request $request)
    {
        // $searchTerm = $request->input('search');
        // $categories = $this->categoryFilterByTermUseCase->execute($searchTerm);

        // return response()->json($categories);
    }
}
