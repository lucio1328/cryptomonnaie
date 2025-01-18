<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\PortefeuilleController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Route pour la page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::prefix('cryptos')->group(function () {
    Route::get('/', [CryptoController::class, 'index'])->name('cryptos.liste');
    Route::get('/evolution', [CryptoController::class, 'evolution'])->name('cryptos.evolution');
});

// Route de connexion
Route::get('login', function () {
    return view('connection');
})->name('login');
Route::post('login', [LoginController::class, 'login']);

// Route d'inscription
Route::get('register', function () {
    return view('inscription');
})->name('register');
Route::post('register', [LoginController::class, 'register']);

Route::get('dashboard', function () {
    return view('dashboard');
});

Route::prefix('portefeuilles')->group(function () {
    Route::get('/', [PortefeuilleController::class, 'index'])->name('portefeuilles.liste');
    Route::get('/create', [PortefeuilleController::class, 'create'])->name('portefeuilles.form');
    Route::post('/create', [PortefeuilleController::class, 'store'])->name('portefeuilles.create');
    Route::get('/show/{id}', [PortefeuilleController::class, 'show'])->name('portefeuilles.show');
    Route::get('/fonds/{id}', [PortefeuilleController::class, 'gererFonds'])->name('portefeuilles.fonds');
    Route::post('/fonds/{id}', [PortefeuilleController::class, 'storeFonds'])->name('portefeuilles.storeFonds');
});

Route::get('/fond/confirmation/{id}', [PortefeuilleController::class, 'confirmFonds'])->name('fonds.confirmation');

Route::prefix('transactions')->group(function() {
    Route::get('/form', [TransactionController::class, 'create'])->name('transactions.form');
    Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/vente/{idUtilisateur}', [TransactionController::class, 'vente'])->name('transactions.vente');
    Route::get('/achat/{idUtilisateur}', [TransactionController::class, 'achat'])->name('transactions.achat');
    Route::get('/historique', [TransactionController::class, 'historique'])->name('transactions.historique');
});

