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
        // $categories = $this->categoryService->getAllWithRelations();
        // $layers = $this->layerService->getAll();
        //return view('home.index', compact('categories', 'layers'));
        return view('pages.home');
    }

    public function tile()
    {
        return view('home.tile');
    }

    public function coord()
    {
        return view('home.coord');
    }

    public function search(Request $request)
    {
        // $searchTerm = $request->input('search');
        // $categories = $this->categoryFilterByTermUseCase->execute($searchTerm);

        // return response()->json($categories);
    }
}
