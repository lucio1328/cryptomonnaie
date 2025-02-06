<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CryptoController extends Controller
{

    public function index(): JsonResponse
    {
        $cryptos = Crypto::all();
        return response()->json([
            'success' => true,
            'data' => $cryptos
        ], 200);
    }
}
