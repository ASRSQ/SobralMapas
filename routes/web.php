<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DeployController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LayerController;

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
Route::get('/', [HomeController::class, 'index']);
Route::get('/tiles', [HomeController::class, 'tile']);
Route::post('/deploy', [DeployController::class, 'deploy']);
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