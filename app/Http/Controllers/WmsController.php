<?php

namespace App\Http\Controllers;

use App\Application\Services\WmsService;
use Illuminate\Http\Request;

class WmsController extends Controller
{
    private $service;

    public function __construct(WmsService $service)
    {
        $this->service = $service;
    }

    /**
     * Exibe a página de formulário para adicionar um WMS link e lista de links cadastrados.
     */
    public function index()
    {
        // Recupera todos os WMS Links cadastrados
        $wmsLinks = $this->service->getAllWmsLinks();
        return view('admin.wms', compact('wmsLinks'));
    }

    /**
     * Processa o formulário de criação de um WMS link e de seus layers.
     */
    public function store(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'url' => 'required|url',
            'name' => 'required|string|max:255',
            'version' => 'nullable|string|max:10',  // Adicionando a validação para a versão
        ]);

        $version = $request->version ?? '1.3.0';  // Se não passar a versão, usa a versão padrão 1.3.0

        try {
            // Chama o serviço para criar o WMS Link e as camadas associadas
            $this->service->createWmsLinkWithLayers($request->url, $request->name, $version);

            // Redireciona para a página admin.wms com uma mensagem de sucesso
            return redirect()->route('wms.index')->with('success', 'WMS Link e camadas salvos com sucesso!');
        } catch (\Exception $e) {
            // Em caso de erro, redireciona de volta com a mensagem de erro
            return redirect()->back()->withInput()->with('error', 'Erro ao processar o WMS: ' . $e->getMessage());
        }
    }

    /**
     * Atualiza um WMS Link existente.
     */
    public function update(Request $request, $id)
    {
        // Validação dos campos
        $request->validate([
            'url' => 'required|url',
            'name' => 'required|string|max:255',
            'version' => 'nullable|string|max:10',  // Adicionando a validação para a versão
        ]);

        $version = $request->version ?? '1.3.0';  // Se não passar a versão, usa a versão padrão 1.3.0

        try {
            // Atualiza o WMS Link usando o serviço
            $this->service->updateWmsLink($id, $request->name, $request->url, $version);

            // Retorna resposta JSON para o frontend
            return response()->json([
                'success' => true,
                'message' => 'WMS Link atualizado com sucesso!',
                'name' => $request->name,
                'url' => $request->url,
                'version' => $version,
            ]);
        } catch (\Exception $e) {
            // Em caso de erro, retorna resposta JSON com o erro
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o WMS Link: ' . $e->getMessage(),
            ]);
        }
    }

    /**
     * Exclui um WMS Link e suas camadas associadas.
     */
    public function destroy($id)
    {
        try {
            // Exclui o WMS Link usando o serviço
            $this->service->deleteWmsLinkWithLayers($id);

            // Redireciona para a página admin.wms com uma mensagem de sucesso
            return redirect()->route('wms.index')->with('success', 'WMS Link e camadas excluídos com sucesso!');
        } catch (\Exception $e) {
            // Em caso de erro, redireciona de volta com a mensagem de erro
            return redirect()->back()->with('error', 'Erro ao excluir o WMS Link: ' . $e->getMessage());
        }
    }

    /**
     * Obtém as camadas de um WMS Link específico.
     */
    public function getWmsLayersByLink($wmsLinkId)
    {
        try {
            // Chama o serviço para obter as camadas
            $layers = $this->service->getWmsLayersByLink($wmsLinkId);

            return response()->json($layers, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
