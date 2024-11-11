<?php

namespace App\Http\Controllers;

use App\Application\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    // Método para listar, adicionar e editar categorias na mesma página
    public function index(Request $request)
    {
        $categories = $this->categoryService->getAllWithRelations();
        return view('admin.categories', compact('categories'));
    }

    // CRUD

    public function create(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $this->categoryService->createCategory($data);
            return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso.');
        } catch (\InvalidArgumentException $e) {
            Log::error("Erro de argumento inválido: " . $e->getMessage());
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        } catch (Exception $e) {
            Log::error("Erro inesperado: " . $e->getMessage());
            return redirect()->back()->withErrors('Erro ao criar categoria: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, int $id)
    {
        Log::info("Atualizando categoria com ID: {$id}");
    
        // Validação dos dados de entrada
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        try {
            // Tentativa de atualizar a categoria através do serviço
            $updatedCategory = $this->categoryService->updateCategory($id, $data);
    
            // Resposta de sucesso
            return response()->json([
                'success' => true,
                'message' => 'Categoria atualizada com sucesso.',
                'name' => $data['name'],
            ]);
        } catch (\InvalidArgumentException $e) {
            // Tratamento para dados inválidos
            Log::error("Erro de validação: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        } catch (\Exception $e) {
            // Tratamento para outros erros
            if ($e->getMessage() === 'Categoria não encontrada.') {
                Log::error("Erro: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Categoria não encontrada.',
                ], 404);
            } elseif ($e->getMessage() === 'Uma categoria com esse nome já existe.') {
                Log::error("Erro: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Uma categoria com esse nome já existe.',
                ], 409); // Código HTTP 409 para conflito
            } else {
                Log::error("Erro inesperado: " . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Erro inesperado ao atualizar a categoria.',
                ], 500);
            }
        }
    }
    



    public function delete($id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return redirect()->route('admin.categories')->with('success', 'Categoria excluída com sucesso.');
        } catch (Exception $e) {
            Log::error("Erro ao excluir categoria com ID {$id}: " . $e->getMessage());
            return redirect()->route('admin.categories')->withErrors('Erro ao excluir categoria: ' . $e->getMessage());
        }
    }
}
