<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Layer;

use App\Models\Subcategory;

class LayerController extends Controller
{
     /**
     * Exibe uma lista de layers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $layers = Layer::all();
        return view('layers.index', compact('layers'));
    }

    /**
     * Exibe o formulário para criar um novo layer.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('layers.create', compact('categories', 'subcategories'));
    }
    
    

    /**
     * Armazena um novo layer no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
{
   

    Layer::create([
        'name' => $request->input('name'),
        'layer' => $request->input('layer'),
        'description' => $request->input('description'),
        'category_id' => $request->input('category_id'),
        'subcategory_id' => $request->input('subcategory_id'), // Adicione esta linha
    ]);

    return redirect()->route('layers.index')->with('success', 'Layer criado com sucesso!');
}



    /**
     * Exibe o formulário para editar um layer existente.
     *
     * @param  \App\Models\Layer  $layer
     * @return \Illuminate\View\View
     */
   public function edit($id)
{
    $layer = Layer::findOrFail($id);
    $categories = Category::all();
    $subcategories = Subcategory::all(); // Adicione esta linha

    return view('layers.edit', compact('layer', 'categories', 'subcategories'));
}

    


    /**
     * Atualiza um layer existente no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Layer  $layer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'layer' => 'required|string|max:255',
            'description' => 'required|string',
            'subcategory_id' => 'required|integer|exists:subcategories,id',
            'category_id' => 'required|integer|exists:categories,id'
        ]);
    
        $layer = Layer::findOrFail($id);
        $layer->name = $request->name;
        $layer->layer = $request->layer;
        $layer->description = $request->description;
        $layer->subcategory_id = $request->subcategory_id;
        $layer->category_id = $request->category_id; // Adicione esta linha
        $layer->save();
    
        return redirect()->route('layers.index')->with('success', 'Layer updated successfully.');
    }
    
    

    /**
     * Remove um layer do banco de dados.
     *
     * @param  \App\Models\Layer  $layer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
{
    $layer = Layer::findOrFail($id);
    $layer->delete();

    return redirect()->route('layers.index')->with('success', 'Layer excluído com sucesso!');
}


}
