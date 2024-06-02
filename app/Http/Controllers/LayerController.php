<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Layer;

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
        return view('layers.create', compact('categories'));
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
    ]);

    return redirect()->route('layers.index')->with('success', 'Layer criado com sucesso!');
}


    /**
     * Exibe o formulário para editar um layer existente.
     *
     * @param  \App\Models\Layer  $layer
     * @return \Illuminate\View\View
     */
    public function edit(Layer $layer)
    {
        // Aqui você precisa obter as opções de camada e passá-las para a visualização
        $layerOptions = Layer::pluck('name', 'id');
    
        return view('layers.edit', compact('layer'));
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
        $layer = Layer::findOrFail($id);
        $layer->update($request->all());
    
        return redirect()->route('layers.index')->with('success', 'Layer atualizado com sucesso!');
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
