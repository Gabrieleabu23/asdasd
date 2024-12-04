<?php

namespace Database\Seeders;

use App\Models\Locali;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class LocaliTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dati = $this->getLocalifromApi();

        foreach ($dati as $singleDato) {
            Locali::create([
                'id_tomtom' => $singleDato['id'],
                'name' => $singleDato['poi']['name'],
                'localita' => $singleDato['address']['municipality'],
                'regione' => isset($singleDato['address']['countrySubdivisionName'])
                    ? ($singleDato['address']['countrySubdivisionName'] == "Lombardy" ? 'Lombardia' : $singleDato['address']['countrySubdivisionName'])
                    : 'Non Specificata',
                'latitudine' => $singleDato['position']['lat'],
                'longitudine' => $singleDato['position']['lon'],
                'indirizzo' => $singleDato['address']['freeformAddress'],
            ]);
        }
        $jsonData = json_encode($dati, JSON_PRETTY_PRINT);
        $filePath = public_path('Locali_salvati.json');
        file_put_contents($filePath, $jsonData);


    }
    private function getLocalifromApi()
    {
        // La tua chiave API di TomTom
        $apiKey = "JaJJHJ6GGLUhADXt9Iuu4C5oaRT5Ah96";  // Sostituisci con la tua chiave API

        // Definisci le coordinate per le città (Bologna, Reggio Emilia, Veneto)
        $coordinates = [
            // Emilia-Romagna
            ['lat' => 44.5010073, 'lon' => 11.3427465, 'city' => 'Bologna'],   // Bologna
            ['lat' => 44.698297, 'lon' => 10.630245, 'city' => 'Reggio Emilia'], // Reggio Emilia
            ['lat' => 44.0521, 'lon' => 11.2025, 'city' => 'Modena'],          // Modena
            ['lat' => 44.4949, 'lon' => 11.3425, 'city' => 'Ferrara'],         // Ferrara
            ['lat' => 44.6367, 'lon' => 10.2512, 'city' => 'Piacenza'],        // Piacenza
            ['lat' => 44.4091, 'lon' => 11.9164, 'city' => 'Cesena'],          // Cesena
            ['lat' => 44.7109, 'lon' => 11.2333, 'city' => 'Forlì'],           // Forlì
            ['lat' => 44.3075, 'lon' => 11.6264, 'city' => 'Imola'],           // Imola
            ['lat' => 44.6965, 'lon' => 12.2661, 'city' => 'Ravenna'],         // Ravenna
            ['lat' => 44.1643, 'lon' => 12.2363, 'city' => 'Cesenatico'],      // Cesenatico
            ['lat' => 44.1814, 'lon' => 11.6126, 'city' => 'Lugo'],            // Lugo

            // Veneto
            ['lat' => 45.4408, 'lon' => 12.3155, 'city' => 'Venezia'],          // Venezia
            ['lat' => 45.0566, 'lon' => 10.7911, 'city' => 'Verona'],          // Verona
            ['lat' => 45.1602, 'lon' => 11.1303, 'city' => 'Padova'],          // Padova
            ['lat' => 45.0703, 'lon' => 11.1237, 'city' => 'Vicenza'],         // Vicenza
            ['lat' => 45.1855, 'lon' => 11.3937, 'city' => 'Treviso'],         // Treviso
            ['lat' => 45.6591, 'lon' => 11.3989, 'city' => 'Belluno'],         // Belluno
            ['lat' => 45.4900, 'lon' => 11.5492, 'city' => 'Rovigo'],          // Rovigo
            ['lat' => 45.5535, 'lon' => 10.7015, 'city' => 'Chioggia'],        // Chioggia
            ['lat' => 45.2990, 'lon' => 11.0193, 'city' => 'Mestre'],          // Mestre
            ['lat' => 45.6023, 'lon' => 11.5155, 'city' => 'San Donà di Piave'], // San Donà di Piave
            ['lat' => 45.6824, 'lon' => 12.2204, 'city' => 'Cologna Veneta'],   // Cologna Veneta
        ];
        // Categorie per la ricerca (Live Music, Bar, ecc.)
        $categorySet = '7318003,7318002,9379008';  // Codici per "Live Music", "Bars", "Entertainment"

        // Array per memorizzare tutti i risultati
        $locales = [];

        // Cicla su ogni città e fai la ricerca dei locali
        foreach ($coordinates as $location) {
            $response = Http::get('https://api.tomtom.com/search/2/nearbySearch.json', [
                'lat' => $location['lat'],
                'lon' => $location['lon'],
                'radius' => 50000,  // Raggio di ricerca in metri (50 km)
                'categorySet' => $categorySet,  // Codici delle categorie per "Live Music", "Bars", ecc.
                'view' => 'Unified',  // Tipo di risposta
                'relatedPois' => 'off',  // Escludi POI correlati
                'key' => $apiKey,  // La tua chiave API TomTom
            ]);

            // Verifica se la richiesta è andata a buon fine
            if ($response->successful()) {
                $data = $response->json();  // Decodifica la risposta JSON

                // Aggiungi i risultati alla lista locale
                $locales = array_merge($locales, $data['results']);  // Aggiungi i nuovi risultati al array
            } else {
                // Gestisci l'errore nella richiesta
                // (opzionale) Puoi anche gestire questo errore se vuoi loggare qualcosa
                // $locales[] = ['error' => 'Errore nella richiesta per la città ' . $location['city']];
            }
        }

        // Restituisci tutti i locali trovati
        return $locales;
    }
}
