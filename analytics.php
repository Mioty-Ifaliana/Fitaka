<?php 
require_once 'vendor/autoload.php';

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;
use Google\Analytics\Data\V1beta\RunReportRequest;
use Google\Analytics\Data\V1beta\DateRange;
use Google\Analytics\Data\V1beta\Metric;

function getAnalyticsData() {
    // Définition du chemin temporaire des credentials
    $credentialsJson = getenv("GOOGLE_APPLICATION_CREDENTIALS_JSON");
    
    if (!$credentialsJson) {
        echo json_encode(["error" => "La variable d'environnement des credentials est introuvable."]);
        return;
    }

    // Création du fichier temporaire
    $credentialsPath = '/tmp/service_account.json';
    file_put_contents($credentialsPath, $credentialsJson);
    putenv("GOOGLE_APPLICATION_CREDENTIALS=$credentialsPath");

    // Définition du Property ID
    $property_id = "349501815"; // NE PAS CHANGER

    try {
        // Initialisation du client
        $client = new BetaAnalyticsDataClient();

        // Définition de la plage de dates
        $dateRange = new DateRange([
            'start_date' => '7daysAgo',
            'end_date' => 'today'
        ]);

        // Définition des métriques
        $metrics = [
            new Metric(['name' => 'activeUsers']),
            new Metric(['name' => 'eventCount']),
            new Metric(['name' => 'screenPageViews'])
        ];

        // Création de la requête
        $request = new RunReportRequest([
            'property' => "properties/{$property_id}",
            'date_ranges' => [$dateRange],
            'metrics' => $metrics
        ]);

        // Exécution de la requête
        $response = $client->runReport($request);

        // Traitement des résultats
        $data = [];
        foreach ($response->getRows() as $row) {
            $values = $row->getMetricValues();
            $data[] = [
                'activeUsers' => $values[0]->getValue(),
                'eventCount' => $values[1]->getValue(),
                'screenPageViews' => $values[2]->getValue()
            ];
        }

        // Affichage des résultats en JSON
        header('Content-Type: application/json');
        echo json_encode($data, JSON_PRETTY_PRINT);

    } catch (Exception $e) {
        echo json_encode(["error" => "Erreur lors de la récupération des données : " . $e->getMessage()]);
    }
}

// Exécuter la fonction
getAnalyticsData();
?>
