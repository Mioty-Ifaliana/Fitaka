<?php
require_once 'myCon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    if ($db) {
        $nom = $_POST['nom'] ?? '';
        $url = $_POST['url'] ?? '';
        $description = $_POST['description'] ?? '';

        try {
            $query = "INSERT INTO demande (nom, url, description) VALUES (:nom, :url, :description)";
            $stmt = $db->prepare($query);

            $stmt->bindParam(":nom", $nom);
            $stmt->bindParam(":url", $url);
            $stmt->bindParam(":description", $description);

            if ($stmt->execute()) {
                header("Location: list.php?success=1");
                exit();
            } else {
                $error = "Une erreur est survenue lors de l'insertion.";
            }
        } catch(PDOException $e) {
            $error = "Erreur: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Demande</title>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CEHGD73MDW"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CEHGD73MDW');
</script>
</head>
<body>
    <header>
        <h1>Nouvelle Demande</h1>
        <nav>
            <a href="index.php">À propos</a> |
            <a href="list.php">Liste des demandes</a>
        </nav>
    </header>

    <main>

        <form method="POST" action="traitement.php">
            <div style="margin-bottom: 15px;">
                <label for="nom">Nom:</label><br>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div style="margin-bottom: 15px;">
                <label for="url">URL:</label><br>
                <input type="url" id="url" name="url">
            </div>

            <div style="margin-bottom: 15px;">
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>

            <button type="submit">Envoyer</button>
        </form>
    </main>

    <footer style="margin-top: 50px; text-align: center;">
        <p>&copy; 2025 FITAKA. Tous droits réservés.</p>
    </footer>
</body>
</html>
