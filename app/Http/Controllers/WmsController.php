<?php

namespace App\Http\Controllers;

use App\Infrastructure\Adapters\WmsAdapter;
use Illuminate\Http\Request;

class WmsController extends Controller
{
    protected $wmsAdapter;

    public function __construct(WmsAdapter $wmsAdapter)
    {
        $this->wmsAdapter = $wmsAdapter;
    }

    public function index()
    {
        return view('admin.wms');
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        try {
            // Usando o WmsAdapter para coletar e armazenar os dados
            $wmsLink = $this->wmsAdapter->fetchAndStoreWmsData($request->url);
            return response()->json(['message' => 'Dados WMS armazenados com sucesso!', 'wms_link' => $wmsLink]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}

