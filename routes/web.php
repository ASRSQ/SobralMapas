<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DeployController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LayerController;
use App\Http\Controllers\ChatbotController;

use App\Http\Controllers\SubcategoryController;

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
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
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

// Adicionando a rota sendMessage no HomeController
Route::post('/send-message', [HomeController::class, 'sendMessage'])->name('chat.sendMessage');