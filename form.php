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

<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Demande</title>
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
        <?php
        // Affichage des erreurs
        if (isset($_SESSION['error'])) {
            echo '<p style="color: red;">' . $_SESSION['error'] . '</p>';
            unset($_SESSION['error']);
        }
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $error) {
                echo '<p style="color: red;">' . $error . '</p>';
            }
            unset($_SESSION['errors']);
        }
        ?>

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
