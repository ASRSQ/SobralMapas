<?php

namespace App\Http\Controllers;
use App\Models\Layer;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
class HomeController extends Controller
{
    public function index()
    {
        // Busca todas as categorias
        $categories = Category::all();

        // Busca todas as camadas
        $layers = Layer::all();
        
        // Busca todas as subcategorias
        $subcategories = Subcategory::all();

        // Retorna a view 'home.index' com as categorias, subcategorias e camadas
        return view('home.index', compact('categories', 'layers', 'subcategories'));
    }
    public function tile()
    {
        return view('home.tile');
    }
    public function coord()
    {
        return view('home.coord');
    }
}
