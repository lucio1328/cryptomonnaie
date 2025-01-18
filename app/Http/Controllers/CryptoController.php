<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use Illuminate\Http\Request;

class CryptoController extends Controller
{

    public function index()
    {
        $cryptos = Crypto::all();
        return view('cryptos.index', compact('cryptos'));
    }
}
