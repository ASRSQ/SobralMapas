<?php

namespace App\Http\Controllers;

use App\Application\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;

class CategoryController
{

    private CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    //PAGES

    public function index()
    {
        $categories = $this->categoryService->getAll();

        return view('categories.index', compact('categories'));
    }

    public function createPage()
    {
        return view('categories.create');
    }

    public function editPage($id)
    {
        $category = $this->categoryService->findCategoryById($id);
        return view('categories.edit', compact('category'));
    }

    // CRUD
    public function create(Request $request): RedirectResponse
    {
        try {
            $data = $request->all();

            // Chama o serviço, que por sua vez chama o Use Case para criar a categoria
            $this->categoryService->createCategory($data);

            return redirect()->route('categories.index')->with('success', 'Categoria criada com sucesso.');
        } catch (\InvalidArgumentException $e) {

            // Redireciona de volta com os erros de validação
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        } catch (\Exception $e) {

            // Redireciona de volta com outros erros
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        try {
            $data = $request->all();

            // Chama o serviço, que por sua vez chama o Use Case para atualizar a categoria
            $this->categoryService->updateCategory($id, $data);

            return redirect()->route('categories.index')
                ->with('success', 'Categoria atualizada com sucesso.');
        } catch (\InvalidArgumentException $e) {
            // Redireciona de volta com os erros de validação
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        } catch (Exception $e) {
            // Redireciona de volta com outros erros
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function delete($id)
    {
        $this->categoryService->deleteCategory($id);

        return redirect()->route('categories.index')
            ->with('success', 'Categoria excluída com sucesso.');
    }
}
