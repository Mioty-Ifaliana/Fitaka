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
