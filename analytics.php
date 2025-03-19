<?php
require_once 'vendor/autoload.php';

use Google\Client;
use Google\Service\AnalyticsData;

function getAnalyticsData() {
    $client = new Client();
    $client->setAuthConfig('fitaka-d87a41b77f6d.json'); 
    $client->addScope(AnalyticsData::ANALYTICS_READONLY);

    $analytics = new AnalyticsData($client);

    $propertyId = "349501815"; 

    $request = new Google\Service\AnalyticsData\RunReportRequest([
        'dateRanges' => [['startDate' => '7daysAgo', 'endDate' => 'today']],
        'metrics' => [
            ['name' => 'activeUsers'],    // Nombre d'utilisateurs
            ['name' => 'eventCount'],     // Nombre total d'événements (clics)
            ['name' => 'screenPageViews'] // Nombre de vues des pages
        ],
        'dimensions' => [
            ['name' => 'eventName'] // Type d'événements (ex: clics sur bouton)
        ]
    ]);

    // Exécuter la requête
    $response = $analytics->properties->runReport("properties/{$propertyId}", $request);

    return $response;
}

// Récupérer les données
$data = getAnalyticsData();

// Affichage des résultats en JSON
echo json_encode($data, JSON_PRETTY_PRINT);
?>
