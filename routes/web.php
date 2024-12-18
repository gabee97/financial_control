<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Register web routes for the application. These routes are loaded by the
| RouteServiceProvider within a group which contains the "web" middleware group.
|
*/

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// Dashboard - Protegido por autenticação
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    // Rotas de perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rotas de categorias e transações
    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);
});


Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return "Conexão com o banco de dados bem-sucedida! Banco: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Erro ao conectar ao banco de dados: " . $e->getMessage();
    }
});


// Rotas de autenticação (Breeze)
require __DIR__.'/auth.php';
