<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Crypto;
use App\Models\HistoriqueCours;
use Carbon\Carbon;

class GenerateCryptoPrices extends Command
{
    protected $signature = 'generate:crypto-prices';
    protected $description = 'Générer des données en quise de cours pour chaque cryptomonnaie toutes les 10s';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cryptos = Crypto::all();

        while(true) {
            foreach ($cryptos as $crypto) {
                $cours = mt_rand(10000, 50000);
                HistoriqueCours::create([
                    'cours' => $cours,
                    'date_enregistrement' => Carbon::now(),
                    'id_cryptos' => $crypto->id_cryptos
                ]);
            }

            sleep(10);
        }
    }
}
