<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Analytics</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Statistiques Google Analytics</h1>
    <p><strong>Nombre d'utilisateurs actifs :</strong> <span id="users">Chargement...</span></p>
    <p><strong>Nombre total de clics :</strong> <span id="clicks">Chargement...</span></p>
    <p><strong>Nombre de vues de pages :</strong> <span id="pageviews">Chargement...</span></p>

    <script>
        $(document).ready(function() {
            $.getJSON("analytics.php", function(data) {
                if (data.error) {
                    alert("Erreur : " + data.error);
                } else {
                    $("#users").text(data.activeUsers || "0");
                    $("#clicks").text(data.eventCount || "0");
                    $("#pageviews").text(data.screenPageViews || "0");
                }
            }).fail(function() {
                alert("Impossible de récupérer les données Analytics.");
            });
        });
    </script>
</body>
</html>
