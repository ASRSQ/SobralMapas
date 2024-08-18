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

    // Filtra as camadas com base no termo de pesquisa
    if ($searchTerm) {
        $filteredLayers = [];
        foreach ($layers as $layer) {
            if (stripos($layer->name, $searchTerm) !== false) {
                $filteredLayers[] = $layer;
            }
        }
        $layers = collect($filteredLayers);

        // Filtra as subcategorias que contêm camadas correspondentes
        $filteredSubcategories = $subcategories->filter(function ($subcategory) use ($layers) {
            return $layers->contains('subcategory_id', $subcategory->id);
        });

        // Filtra as categorias que contêm subcategorias correspondentes
        $filteredCategories = $categories->filter(function ($category) use ($filteredSubcategories) {
            return $filteredSubcategories->contains('category_id', $category->id);
        });
    } else {
        $filteredCategories = $categories;
        $filteredSubcategories = $subcategories;
    }

    // Retorna a resposta em JSON para a requisição AJAX
    if ($request->ajax()) {
        return response()->json([
            'categories' => $filteredCategories->values(),
            'subcategories' => $filteredSubcategories->values(),
            'layers' => $layers->values()
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
