<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateCryptoCourse extends Command
{
    protected $signature = 'crypto:generate-course';

    protected $description = 'Générer un nouveau cours pour chaque crypto toutes les 10 secondes';

    public function handle()
    {
        $cryptos = DB::table('cryptos')->get();

        foreach ($cryptos as $crypto) {
            $cours = rand(100, 5000) / 100;

            DB::table('historique_cours')->insert([
                'cours' => $cours,
                'date_enregistrement' => now(),
                'id_cryptos' => $crypto->id_cryptos
            ]);

            $this->info("Cours généré pour la crypto {$crypto->nom_crypto}: {$cours}");
        }
    }
}
