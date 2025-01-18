<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckDateDifference
{
    public function handle(Request $request, Closure $next)
    {
        // Récupérer toutes les cryptos
        $cryptos = DB::table('cryptos')->get();

            // Récupérer la dernière entrée historique_cours pour chaque crypto
            $result = DB::table('historique_cours')
                        ->orderBy('date_enregistrement', 'desc')
                        ->first();

            if ($result) {
                // Convertir date_enregistrement en instance Carbon pour faciliter la comparaison
                $date_enregistrement = Carbon::parse($result->date_enregistrement);

                // Vérifier si la différence entre l'heure actuelle et la date_enregistrement est supérieure ou égale à 10 secondes
                $now = Carbon::now();
                $difference = $now->diffInSeconds($date_enregistrement);

                if ($difference >= 10) {
                    // Si la différence est supérieure ou égale à 10 secondes, on insère un nouveau historique de cours
                    foreach ($cryptos as $crypto) {
                        // Générer un nouveau cours aléatoire
                        $cours = rand(100, 5000) / 100;

                        // Insérer le nouveau cours dans la table historique_cours pour chaque crypto
                        DB::table('historique_cours')->insert([
                            'cours' => $cours,
                            'date_enregistrement' => now(),
                            'id_cryptos' => $crypto->id_cryptos
                        ]);

                        Log::info("Nouveau cours généré pour la crypto ID {$crypto->id_cryptos}: {$cours}");
                    }
                }

            } else {
                foreach ($cryptos as $crypto) {
                    // Si aucune entrée historique_cours n'existe pour la crypto, insérer un premier cours
                    $cours = rand(100, 5000) / 100;

                    DB::table('historique_cours')->insert([
                        'cours' => $cours,
                        'date_enregistrement' => now(),
                        'id_cryptos' => $crypto->id_cryptos
                    ]);

                    Log::info("Premier cours généré pour la crypto ID {$crypto->id_cryptos}: {$cours}");
                }
            }

        // Continuer avec la requête
        return $next($request);
    }
}
