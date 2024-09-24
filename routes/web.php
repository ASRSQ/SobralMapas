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

// Definir rotas para categorias
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'createPage'])->name('categories.createPage');
Route::post('/categories', [CategoryController::class, 'create'])->name('categories.create');
Route::get('/categories/{category}/edit', [CategoryController::class, 'editPage'])->name('categories.editPage');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'delete'])->name('categories.delete');



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
Route::post('/send-message', [HomeController::class, 'sendMessage'])->name('chat.sendMessage');

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
