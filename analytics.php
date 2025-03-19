<?php 
require_once 'vendor/autoload.php';

use Google\Client;
use Google\Service\AnalyticsData;

function getAnalyticsData() {
    $client = new Client();
    
    // Récupération du chemin des credentials depuis l'environnement
    $credentialsPath = getenv("GOOGLE_APPLICATION_CREDENTIALS_JSON");
    
    if (!$credentialsPath || !file_exists($credentialsPath)) {
        echo json_encode(["error" => "Le fichier d'identification est introuvable."]);
        return;
    }

    // Configuration du client Google avec le fichier credentials.json
    $client->setAuthConfig($credentialsPath);
    $client->addScope("https://www.googleapis.com/auth/analytics.readonly");

    // Vérification du token d'accès
    if ($client->isAccessTokenExpired()) {
        echo json_encode(["error" => "Le token d'accès est expiré ou invalide."]);
        return;
    }

    $analytics = new AnalyticsData($client);
    $propertyId = "349501815"; // Remplace par ton vrai Property ID

    // Test pour voir si le service account a accès à Google Analytics
    try {
        $accounts = $analytics->properties->listProperties();
        if (empty($accounts->getProperties())) {
            echo json_encode(["error" => "Aucune propriété trouvée. Assurez-vous que le service account a bien accès à Google Analytics."]);
            return;
        }
    } catch (Exception $e) {
        echo json_encode(["error" => "Erreur lors de l'accès aux propriétés: " . $e->getMessage()]);
        return;
    }

    // Requête des données d'Analytics
    $request = new Google\Service\AnalyticsData\RunReportRequest([
        'dateRanges' => [['startDate' => '7daysAgo', 'endDate' => 'today']],
        'metrics' => [
            ['name' => 'activeUsers'],    
            ['name' => 'eventCount'],     
            ['name' => 'screenPageViews']
        ]
    ]);

    try {
        $response = $analytics->properties->runReport("properties/{$propertyId}", $request);
        $results = [];

        foreach ($response->getRows() as $row) {
            foreach ($row->getMetricValues() as $index => $metricValue) {
                $metricName = $response->getMetricHeaders()[$index]->getName();
                $results[$metricName] = $metricValue->getValue();
            }
        }

        echo json_encode($results, JSON_PRETTY_PRINT);
    } catch (Exception $e) {
        echo json_encode(["error" => "Erreur lors de la récupération des données : " . $e->getMessage()]);
    }
}

getAnalyticsData();
?>
