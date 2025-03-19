<?php
require_once 'vendor/autoload.php';

use Google\Client;
use Google\Service\AnalyticsReporting;

function getAnalyticsData() {
    $credentialsJson = getenv("GOOGLE_APPLICATION_CREDENTIALS_JSON");

    if (!$credentialsJson) {
        echo json_encode(["error" => "La variable d'environnement des credentials est introuvable."]);
        return;
    }

    // Créer un fichier temporaire pour stocker les credentials
    $credentialsPath = '/tmp/service_account.json';
    file_put_contents($credentialsPath, $credentialsJson);

    // Initialisation du client Google
    $client = new Client();
    $client->setAuthConfig($credentialsPath);
    $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);

    // Initialisation du service Google Analytics
    $analytics = new AnalyticsReporting($client);

    // Paramètres de la requête
    $VIEW_ID = "349501815"; // Remplace avec ton View ID Google Analytics

    $dateRange = new Google\Service\AnalyticsReporting\DateRange();
    $dateRange->setStartDate("7daysAgo");
    $dateRange->setEndDate("today");

    $metrics = new Google\Service\AnalyticsReporting\Metric();
    $metrics->setExpression("ga:users");

    $request = new Google\Service\AnalyticsReporting\ReportRequest();
    $request->setViewId($VIEW_ID);
    $request->setDateRanges($dateRange);
    $request->setMetrics([$metrics]);

    $body = new Google\Service\AnalyticsReporting\GetReportsRequest();
    $body->setReportRequests([$request]);

    try {
        // Exécuter la requête
        $reports = $analytics->reports->batchGet($body);

        $rows = $reports->getReports()[0]->getData()->getRows();
        $users = $rows ? $rows[0]->getMetrics()[0]->getValues()[0] : 0;

        // Affichage en JSON
        header('Content-Type: application/json');
        echo json_encode(["users" => $users]);

    } catch (Exception $e) {
        echo json_encode(["error" => "Erreur lors de la récupération des données : " . $e->getMessage()]);
    }
}

// Exécuter la fonction
getAnalyticsData();
?>
