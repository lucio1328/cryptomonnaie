<?php

namespace App\Http\Controllers;

use App\Models\Fonds;
use Illuminate\Http\Request;

class FondController extends Controller
{
    public function getFond() {
        $user = session('user');
        $detailFond = Fonds::fondTotal($user->id_utilisateur);

        return response()->json([
            'success' => true,
            'data' => $detailFond
        ]);
    }
}
