<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DeployController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LayerController;
use App\Http\Controllers\ChatbotController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GeoServerProxyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\WmsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');



Route::get('/tiles', [HomeController::class, 'tile']);
Route::get('/coord', [HomeController::class, 'coord']);
//admin
Route::get('/admin', [AdminController::class, 'index']);
// Definir rotas para categorias
Route::prefix('admin/categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/', [CategoryController::class, 'create'])->name('categories.create');
    Route::put('/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('{id}', [CategoryController::class, 'delete'])->name('categories.delete');
});
Route::prefix('admin/subcategories')->group(function () {
    Route::get('/', [SubcategoryController::class, 'index'])->name('subcategories.index');
    Route::post('/', [SubcategoryController::class, 'create'])->name('subcategories.create');
    Route::put('/{id}', [SubcategoryController::class, 'update'])->name('subcategories.update');
    Route::delete('{id}', [SubcategoryController::class, 'delete'])->name('subcategories.delete');
});

Route::prefix('admin/layers')->group(function () {
    Route::get('/', [LayerController::class, 'index'])->name('admin.layers.index');  // Listar layers
    Route::post('/', [LayerController::class, 'store'])->name('admin.layers.store');  // Criar layer
    Route::get('{id}/edit', [LayerController::class, 'edit'])->name('admin.layers.edit');  // Editar layer
    Route::put('{id}', [LayerController::class, 'update'])->name('admin.layers.update');  // Atualizar layer
    Route::delete('{id}', [LayerController::class, 'destroy'])->name('admin.layers.destroy');  // Deletar layer
});
Route::prefix('admin/wms')->group(function () {
    // Exibir o formulário de criação e a lista de links WMS
    Route::get('/', [WmsController::class, 'index'])->name('admin.wms.index');  // Listar WMS links
    Route::post('/', [WmsController::class, 'store'])->name('admin.wms.store');  // Criar WMS link
    Route::get('{id}/edit', [WmsController::class, 'edit'])->name('admin.wms.edit');  // Editar WMS link
    Route::put('{id}', [WmsController::class, 'update'])->name('admin.wms.update');  // Atualizar WMS link
    Route::delete('{id}', [WmsController::class, 'destroy'])->name('admin.wms.destroy');  // Deletar WMS link
    Route::get('/{id}/layers',[WmsController::class, 'getWmsLayersByLink']);
});


/*
Route::get('/layers', [LayerController::class, 'index'])->name('layers.index');
Route::get('/layers/create', [LayerController::class, 'create'])->name('layers.create');
Route::post('/layers', [LayerController::class, 'store'])->name('layers.store');
Route::get('/layers/{layer}/edit', [LayerController::class, 'edit'])->name('layers.edit');
Route::put('/layers/{layer}', [LayerController::class, 'update'])->name('layers.update');
Route::delete('/layers/{layer}', [LayerController::class, 'destroy'])->name('layers.destroy');
Route::get('/subcategories', [SubcategoryController::class, 'index'])->name('subcategories.index');
Route::get('/subcategories/create', [SubcategoryController::class, 'create'])->name('subcategories.create');
Route::post('/subcategories', [SubcategoryController::class, 'store'])->name('subcategories.store');
Route::get('/subcategories/{subcategory}', [SubcategoryController::class, 'show'])->name('subcategories.show');
Route::get('/subcategories/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('subcategories.edit');
Route::put('/subcategories/{subcategory}', [SubcategoryController::class, 'update'])->name('subcategories.update');
Route::delete('/subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');
Route::get('/bot', [ChatbotController::class, 'index']);
Route::post('/chat', [ChatbotController::class, 'chat']);
Route::get('/admin', [AdminController::class, 'index']);
*/
// Adicionando a rota sendMessage no HomeController
//Route::post('/send-message', [HomeController::class, 'sendMessage'])->name('chat.sendMessage');

// Route::get('/proxy-wms', function (Request $request) {
//     // Captura todos os parâmetros recebidos na requisição original
//     $params = $request->all();

//     // Log dos parâmetros recebidos (para depuração)
//     Log::info('WMS Request Params:', $params);

//     // Faz a requisição ao GeoServer passando os parâmetros
//     $response = Http::withHeaders([
//         'Accept' => 'image/png'
//     ])->get('http://geoserver.sobral.ce.gov.br/geoserver/ows', $params);

//     // Log da resposta recebida (para depuração)
//     Log::info('GeoServer Response:', ['status' => $response->status()]);

//     // Verifica se a requisição foi bem-sucedida
//     if ($response->successful()) {
//         return response($response->body(), 200)
//                ->header('Content-Type', 'image/png');
//     } else {
//         return response('Erro ao carregar a camada WMS.', 500);
//     }
// });
