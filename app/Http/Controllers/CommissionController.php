<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;

class CommissionController extends Controller
{
    public function index()
    {
        return response()->json(Commission::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_cryptos' => 'required|integer',
            'id_type_transaction' => 'required|integer',
            'pourcentage' => 'required|numeric',
            'daty' => 'required|date',
        ]);

        $commission = Commission::create($request->all());

        return response()->json($commission, 201);
    }

    public function show($id)
    {
        $commission = Commission::find($id);

        if (!$commission) {
            return response()->json(['message' => 'Commission non trouvée'], 404);
        }

        return response()->json($commission);
    }

    public function update(Request $request, $id)
    {
        $commission = Commission::find($id);

        if (!$commission) {
            return response()->json(['message' => 'Commission non trouvée'], 404);
        }

        $commission->update($request->all());

        return response()->json($commission);
    }

    public function destroy($id)
    {
        $commission = Commission::find($id);

        if (!$commission) {
            return response()->json(['message' => 'Commission non trouvée'], 404);
        }

        $commission->delete();

        return response()->json(['message' => 'Commission supprimée avec succès']);
    }
}
