<?php

namespace App\Http\Controllers;

use App\Models\Crypto;
use App\Models\Cryptos;
use App\Models\HistoriqueCours;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AnalyseController extends Controller
{
    public function showAnalyseForm()
    {
        $cryptos = Crypto::all();
        return view('form');
    }

    public function generateAnalysis(Request $request)
    {
        $request->validate([
            'analyse_type' => 'required',
            'crypto' => 'required',
            'date_min' => 'required|date',
            'date_max' => 'required|date|after_or_equal:date_min',
        ]);

        $cryptos = Crypto::whereIn('Id_cryptos', $request->crypto)->get();
        $date_min = Carbon::parse($request->date_min);
        $date_max = Carbon::parse($request->date_max);

        $analysisResults = [];

        foreach ($cryptos as $crypto) {
            $historicalData = HistoriqueCours::where('id_cryptos', $crypto->Id_cryptos)
                ->whereBetween('date_enregistrement', [$date_min, $date_max])
                ->pluck('cours')
                ->toArray();

            $result = $this->performAnalysis($historicalData, $request->analyse_type);
            $analysisResults[$crypto->nom_crypto] = $result;
        }

        return view('analyse.result', compact('analysisResults', 'date_min', 'date_max'));
    }

    private function performAnalysis($data, $type)
    {
        switch ($type) {
            case '1er quartile':
                return $this->firstQuartile($data);
            case 'max':
                return max($data);
            case 'min':
                return min($data);
            case 'moyenne':
                return $this->average($data);
            case 'ecart-type':
                return $this->standardDeviation($data);
            default:
                return null;
        }
    }

    private function firstQuartile($data)
    {
        sort($data);
        $count = count($data);
        $index = floor($count / 4);
        return $data[$index];
    }

    private function average($data)
    {
        return array_sum($data) / count($data);
    }

    private function standardDeviation($data)
    {
        $mean = $this->average($data);
        $sum = 0;
        foreach ($data as $value) {
            $sum += pow($value - $mean, 2);
        }
        return sqrt($sum / count($data));
    }
}

