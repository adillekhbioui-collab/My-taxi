<?php

namespace Database\Seeders;

use App\Models\Trajet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TrajetSeeder extends Seeder
{
    public function run(): void
    {
        $courtier = User::where('role', User::ROLE_COURTIER)->firstOrFail();

        $paires = [
            // Bahraoui
            ['Bahraoui', 'Salé',       35],
            ['Bahraoui', 'Rabat',      40],
            ['Bahraoui', 'Kénitra',    50],
            ['Bahraoui', 'Tiflet',     25],
            // Salé
            ['Salé', 'Kénitra',       55],
            ['Salé', 'Rabat',         15],
            ['Salé', 'Bahraoui',      35],
            ['Salé', 'Tiflet',        40],
            ['Salé', 'Khemisset',     60],
            ['Salé', 'Casablanca',    80],
            // Kénitra
            ['Kénitra', 'Salé',         55],
            ['Kénitra', 'Rabat',        65],
            ['Kénitra', 'Tanger',      110],
            ['Kénitra', 'Casablanca', 140],
            // Rabat
            ['Rabat', 'Kénitra',       65],
            ['Rabat', 'Salé',          15],
            ['Rabat', 'Casablanca',    90],
            ['Rabat', 'Fès',          200],
            ['Rabat', 'Marrakech',    320],
            // Khemisset
            ['Khemisset', 'Tiflet',     20],
            ['Khemisset', 'Salé',       60],
            ['Khemisset', 'Meknès',     75],
            ['Khemisset', 'Rabat',      75],
            // Meknès
            ['Meknès', 'Fès',          65],
            ['Meknès', 'Rabat',       150],
            ['Meknès', 'Casablanca', 220],
            // Fès
            ['Fès', 'Meknès',         65],
            ['Fès', 'Rabat',         200],
            ['Fès', 'Casablanca',    280],
            // Casablanca
            ['Casablanca', 'Rabat',    90],
            ['Casablanca', 'Marrakech', 240],
            // Marrakech
            ['Marrakech', 'Casablanca', 240],
            // Tanger
            ['Tanger', 'Kénitra',     110],
            ['Tanger', 'Tétouan',      60],
            ['Tanger', 'Casablanca',  340],
        ];

        $chauffeurs = [
            ['Abdelkader Tazi',    '+212 661 12 34 56'],
            ['Mohammed Benjelloun','+212 662 23 45 67'],
            ['Said El Fassi',      '+212 663 34 56 78'],
            ['Hassan Berrada',     '+212 664 45 67 89'],
            ['Rachid Chraibi',     '+212 665 56 78 90'],
            ['Brahim Lahlou',      '+212 666 67 89 01'],
            ['Noureddine Kabbaj',  '+212 667 78 90 12'],
            ['Aziz Bencheikh',     '+212 668 89 01 23'],
        ];

        $now = Carbon::now();
        $compteur = 0;

        foreach ($paires as [$depart, $arrivee, $prix]) {
            for ($h = 0; $h < 2; $h++) {
                $offsetHeures = $compteur * 0.5 + 1 + $h * 6;
                if ($offsetHeures > 22) break;

                $heure = $now->copy()->addMinutes((int) ($offsetHeures * 60));

                $placesTotal = 6;
                $placesDispo = max(0, $placesTotal - mt_rand(0, 7));
                $chauffeur = $chauffeurs[array_rand($chauffeurs)];

                Trajet::create([
                    'courtier_id'         => $courtier->id,
                    'ville_depart'        => $depart,
                    'ville_arrivee'       => $arrivee,
                    'heure_depart'        => $heure,
                    'prix'                => $prix,
                    'places_total'        => $placesTotal,
                    'places_disponibles'  => $placesDispo,
                    'chauffeur_nom'       => $chauffeur[0],
                    'chauffeur_tel'       => $chauffeur[1],
                    'statut'              => Trajet::STATUT_PLANIFIE,
                ]);

                $compteur++;
            }
        }
    }
}
