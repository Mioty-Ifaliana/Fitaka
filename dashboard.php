<?php
$analyticsData = file_get_contents("https://fitaka.onrender.com/analytics.php");

if ($analyticsData === false) {
    $data = null;
} else {
    $data = json_decode($analyticsData, true);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Analytics</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 50%; margin: auto; text-align: center; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; }
        th { background-color: #f4f4f4; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Statistiques Google Analytics</h1>

        <?php if ($data === null): ?>
            <p class="error">Erreur : Impossible de récupérer les données Analytics.</p>
        <?php elseif (isset($data['error'])): ?>
            <p class="error">Erreur : <?= htmlspecialchars($data['error']) ?></p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Nombre d'utilisateurs actifs</th>
                        <th>Nombre total de clics</th>
                        <th>Nombre de vues de pages</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (is_array($data) && !empty($data)): ?>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['activeUsers'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['eventCount'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($row['screenPageViews'] ?? 'N/A') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">Aucune donnée disponible</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
