<?php 
require_once 'vendor/autoload.php';

use Google\Client;
use Google\Service\AnalyticsData;

function getAnalyticsData() {
    $client = new Client();
    
    // Récupération du JSON des credentials depuis l'environnement
    $jsonCredentials = getenv("GOOGLE_APPLICATION_CREDENTIALS_JSON");
    if (!$jsonCredentials) {
        echo json_encode(["error" => "Les informations d'identification ne sont pas définies."]);
        return;
    }
    
    $decodedCredentials = json_decode($jsonCredentials, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(["error" => "Erreur de décodage des informations d'identification JSON."]);
        return;
    }
    
    $client->setAuthConfig($decodedCredentials);
    $client->addScope(AnalyticsData::ANALYTICS_READONLY);

    $analytics = new AnalyticsData($client);
    $propertyId = "349501815"; 

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
        echo json_encode(["error" => $e->getMessage()]);
    }
}

getAnalyticsData();
?>