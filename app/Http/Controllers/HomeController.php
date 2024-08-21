<?php

namespace App\Http\Controllers;
use App\Models\Layer;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Busca todas as categorias
        $categories = Category::all();
    
        // Busca todas as subcategorias
        $subcategories = Subcategory::all();
    
        // Busca todas as camadas
        $layers = Layer::all();
    
        // Verifica se há um termo de pesquisa fornecido
        $searchTerm = $request->input('search');
    
        if ($searchTerm) {
            // Filtra as camadas com base no termo de pesquisa
            $filteredLayers = $layers->filter(function ($layer) use ($searchTerm) {
                return stripos($layer->name, $searchTerm) !== false;
            });
    
            // Filtra as subcategorias que contêm camadas correspondentes
            $filteredSubcategories = $subcategories->filter(function ($subcategory) use ($filteredLayers) {
                return $filteredLayers->contains('subcategory_id', $subcategory->id);
            });
    
            // Filtra as categorias que contêm subcategorias correspondentes
            $filteredCategories = $categories->filter(function ($category) use ($filteredSubcategories) {
                return $filteredSubcategories->contains('category_id', $category->id);
            });
    
            // Também filtra as categorias com base no termo de pesquisa e adiciona todas as subcategorias e camadas relacionadas
            $categoryMatches = $categories->filter(function ($category) use ($searchTerm) {
                return stripos($category->name, $searchTerm) !== false;
            });
    
            if ($categoryMatches->isNotEmpty()) {
                // Se encontrar uma categoria correspondente, adiciona todas as subcategorias e camadas relacionadas
                $filteredCategories = $filteredCategories->merge($categoryMatches);
    
                // Adiciona todas as subcategorias relacionadas às categorias encontradas
                $relatedSubcategories = $subcategories->filter(function ($subcategory) use ($categoryMatches) {
                    return $categoryMatches->contains('id', $subcategory->category_id);
                });
    
                $filteredSubcategories = $filteredSubcategories->merge($relatedSubcategories);
    
                // Adiciona todas as camadas relacionadas às subcategorias encontradas
                $relatedLayers = $layers->filter(function ($layer) use ($relatedSubcategories) {
                    return $relatedSubcategories->contains('id', $layer->subcategory_id);
                });
    
                $filteredLayers = $filteredLayers->merge($relatedLayers);
            }
    
            // Também filtra as subcategorias com base no termo de pesquisa e adiciona as camadas relacionadas
            $subcategoryMatches = $subcategories->filter(function ($subcategory) use ($searchTerm) {
                return stripos($subcategory->name, $searchTerm) !== false;
            });
    
            if ($subcategoryMatches->isNotEmpty()) {
                // Adiciona as subcategorias correspondentes à busca
                $filteredSubcategories = $filteredSubcategories->merge($subcategoryMatches);
    
                // Adiciona as categorias relacionadas às subcategorias encontradas
                $relatedCategories = $categories->filter(function ($category) use ($subcategoryMatches) {
                    return $subcategoryMatches->contains('category_id', $category->id);
                });
    
                $filteredCategories = $filteredCategories->merge($relatedCategories);
    
                // Adiciona todas as camadas relacionadas às subcategorias encontradas
                $relatedLayers = $layers->filter(function ($layer) use ($subcategoryMatches) {
                    return $subcategoryMatches->contains('id', $layer->subcategory_id);
                });
    
                $filteredLayers = $filteredLayers->merge($relatedLayers);
            }
    
        } else {
            // Se não houver termo de pesquisa, retornar todas as categorias, subcategorias e camadas
            $filteredCategories = $categories;
            $filteredSubcategories = $subcategories;
            $filteredLayers = $layers;
        }
    
        // Retorna a resposta em JSON para a requisição AJAX
        if ($request->ajax()) {
            return response()->json([
                'categories' => $filteredCategories->values(),
                'subcategories' => $filteredSubcategories->values(),
                'layers' => $filteredLayers->values()
            ]);
        }
    
        // Retorna a view 'home.index' com as categorias, subcategorias e camadas
        return view('home.index', compact('categories', 'subcategories', 'layers'));
    }
    
    
    

    
    

    public function tile()
    {
        return view('home.tile');
    }
    public function coord()
    {
        return view('home.coord');
    }

    public function sendMessage(Request $request)
    {
        // Log para verificar se o método está sendo chamado
        Log::info('Método sendMessage foi chamado.');
    
        // Log para ver o conteúdo da mensagem recebida
        Log::info('Mensagem recebida: ', ['message' => $request->input('message')]);
    
        try {
            $message = $request->input('message');
    
            // Log para ver se a requisição para o servidor do chatbot está sendo feita
            Log::info('Enviando mensagem para o chatbot.');
    
            $response = Http::post('http://localhost:5005/webhooks/rest/webhook', [
                'message' => $message,
                'sender' => 'user'
            ]);
    
            // Log para verificar a resposta recebida do chatbot
            Log::info('Resposta recebida do chatbot: ', $response->json());
    
            $responses = $response->json();
    
            // Retornar a resposta no formato JSON
            return response()->json($responses);
        } catch (\Exception $e) {
            // Log para capturar qualquer erro que ocorra
            Log::error('Erro no método sendMessage: ', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Algo deu errado.'], 500);
        }
    }
}
