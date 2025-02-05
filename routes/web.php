<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CryptoController;
use App\Http\Controllers\PortefeuilleController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

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

Route::prefix('transactions')->group(function () {
    Route::get('/form', [TransactionController::class, 'create'])->name('transactions.form');
    Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/vente/{idUtilisateur}', [TransactionController::class, 'vente'])->name('transactions.vente');
    Route::get('/achat/{idUtilisateur}', [TransactionController::class, 'achat'])->name('transactions.achat');
    Route::get('/historique', [TransactionController::class, 'historique'])->name('transactions.historique');
});

Route::get('/confirmCodePin', function () {
    return view('confirmPIN');
})->name('confirmPin');

Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

Route::get('/sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);

Route::get('/user-validated', [WebhookController::class, 'userValidated']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/test-session', function (\Illuminate\Http\Request $request) {
    session(['test' => 'session working']);
    return response()->json(['message' => 'Session set!']);
});

Route::get('/check-session', function (\Illuminate\Http\Request $request) {
    return response()->json(['session_value' => session('test')]);
});

