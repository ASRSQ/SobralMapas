<?php

namespace App\Http\Controllers;

use App\Application\Services\CategoryService;
use App\Application\Services\SubcategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Barryvdh\Debugbar\Facades\Debugbar;

use Exception;

class SubcategoryController extends Controller
{
    private SubcategoryService $subcategoryService;
    private CategoryService $categoryService;

    public function __construct(SubcategoryService $subcategoryService, CategoryService $categoryService)
    {
        $this->subcategoryService = $subcategoryService;
        $this->categoryService = $categoryService;
    }

    // Método para listar, adicionar e editar subcategorias na mesma página
    public function index(Request $request)
    {
        
        // Retrieve both categories and subcategories
        $categories = $this->categoryService->getAll(); // Fetch categories
        $subcategories = $this->subcategoryService->getAll(); // Fetch subcategories

        return view('admin.subcategories', compact('categories', 'subcategories'));
    }

    // CRUD methods for create, update, and delete remain unchanged...
    
    public function create(Request $request): RedirectResponse
    {
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id', // Ensure the category exists
        ]);
        $data['category_id'] = (int) $data['category_id'];
        
        try {
            $this->subcategoryService->createSubcategory($data);
            return redirect()->route('subcategories.index')->with('success', 'Subcategoria criada com sucesso.');
        } catch (\InvalidArgumentException $e) {
            Log::error("Erro de argumento inválido: " . $e->getMessage());
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        } catch (Exception $e) {
            Log::error("Erro inesperado: " . $e->getMessage());
            return redirect()->back()->withErrors('Erro ao criar subcategoria: ' . $e->getMessage())->withInput();
        }
    }
    public function update(Request $request, int $id)
    {
        Log::info("Atualizando subcategoria com ID: {$id}", [
            'request_data' => $request->all(), // Dados do request para depuração
        ]);
    
        // Validação dos dados de entrada
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer|exists:categories,id', // Verifica a existência da categoria
        ]);
        
        Log::info($data); // Dados do request para d);
        try {
            // Tenta atualizar a subcategoria através do serviço
            $updatedSubcategory = $this->subcategoryService->update($id, $data);
    
            // Resposta de sucesso
            return response()->json([
                'success' => true,
                'message' => 'Subcategoria atualizada com sucesso.',
                'name' => $data['name'],
                'category_name' => $updatedSubcategory->category->name, // Exemplo de retorno da categoria associada
            ]);
        } catch (\InvalidArgumentException $e) {
            // Tratamento de erro de validação
            Log::error("Erro de validação: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Exception $e) {
            // Tratamento de outros erros específicos
            if ($e->getMessage() === 'Subcategoria não encontrada.') {
                Log::error("Erro: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Subcategoria não encontrada.',
                ], 404);
            } elseif ($e->getMessage() === 'Uma subcategoria com esse nome já existe.') {
                Log::error("Erro: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Uma subcategoria com esse nome já existe.',
                ], 409); // Código HTTP 409 para conflito
            } else {
                Log::error("Erro inesperado: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Erro inesperado ao atualizar a subcategoria.',
                ], 500);
            }
        }
    }
    
  


    
        // Método para excluir uma subcategoria
        public function delete($id): RedirectResponse
        {
            //dd($id);
            try {
                $this->subcategoryService->deleteSubcategory($id);
                return redirect()->route('subcategories.index')->with('success', 'Subcategoria excluída com sucesso.');
            } catch (\Exception $e) {
                Log::error("Erro ao excluir subcategoria: " . $e->getMessage());
                return redirect()->back()->withErrors('Erro ao excluir subcategoria: ' . $e->getMessage());
            }
        }
    
}
