<?php

namespace App\Http\Controllers;

use App\Models\Layer;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;

class ChatbotController extends Controller
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
    return view('chatbot.index', compact('categories', 'subcategories', 'layers'));
}


    public function chat(Request $request)
    {
        // 1. Configurar a API do ChatGPT
        $apiKey = env('OPENAI_API_KEY');
        $apiUrl = 'https://api.openai.com/v1/chat/completions';

        // 2. Obter a entrada do usuário
        $userInput = $request->input('userInput');

        // 3. Criar o payload da requisição
        $payload = [
            'model' => 'gpt-3.5-turbo', 
            'messages' => [
                ['role' => 'user', 'content' => $userInput]
            ],
            'temperature' => 0.7 
        ];

        // 4. Fazer a requisição HTTP para a API do ChatGPT
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $response = curl_exec($ch);
        curl_close($ch);

        // 5. Processar a resposta do ChatGPT
        $response = json_decode($response, true);
        $chatbotResponse = $response['choices'][0]['message']['content'];

        // 6. Retornar a resposta para o usuário (usando JSON)
        return response()->json(['message' => $chatbotResponse]);
    }
}
