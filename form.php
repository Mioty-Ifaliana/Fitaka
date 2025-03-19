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
<style>
    /* Reset de base */
    body, h1, p, a, label, input, textarea, button {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    body {
        background-color: #000; /* Fond noir */
        color: #fff; /* Texte blanc */
        line-height: 1.6;
        padding: 20px;
    }

    header {
        text-align: center;
        padding: 20px 0;
        border-bottom: 2px solid #fff; /* Ligne de séparation */
    }

    header h1 {
        font-size: 2.5em;
        font-weight: bold;
    }

    nav {
        margin-top: 10px;
    }

    nav a {
        color: #fff; /* Texte blanc */
        text-decoration: none;
        margin: 0 10px;
        font-weight: bold;
    }

    nav a:hover {
        text-decoration: underline; /* Soulignement au survol */
    }

    main {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    form {
        background-color: #111; /* Fond gris très foncé */
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #fff; /* Bordure blanche */
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #fff; /* Texte blanc */
    }

    input[type="text"],
    input[type="url"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #fff; /* Bordure blanche */
        border-radius: 5px;
        background-color: #000; /* Fond noir */
        color: #fff; /* Texte blanc */
        font-size: 1em;
    }

    textarea {
        resize: vertical; /* Permet le redimensionnement vertical uniquement */
    }

    button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #fff; /* Fond blanc */
        color: #000; /* Texte noir */
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    button:hover {
        background-color: #000; /* Fond noir au survol */
        color: #fff; /* Texte blanc au survol */
        border: 1px solid #fff; /* Bordure blanche au survol */
    }

    footer {
        margin-top: 50px;
        text-align: center;
        padding: 20px 0;
        border-top: 2px solid #fff; /* Ligne de séparation */
        font-size: 0.9em;
        color: #ddd; /* Texte gris clair */
    }

    /* Style pour les messages d'erreur */
    p[style*="color: red;"] {
        background-color: #222; /* Fond gris très foncé */
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ff4444; /* Bordure rouge */
        margin-bottom: 20px;
        color: #ff4444; /* Texte rouge */
    }
</style>
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
