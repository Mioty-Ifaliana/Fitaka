<?php
session_start();
require_once 'myCon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    if ($db) {
        $nom = $_POST['nom'] ?? '';
        $description = $_POST['description'] ?? '';
        
        // Génération de l'URL SEO-friendly
        $url = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $nom)));
        
        // Vérification si l'URL existe déjà
        $stmt = $db->prepare("SELECT COUNT(*) FROM demande WHERE url = ?");
        $stmt->execute([$url]);
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            $url = $url . '-' . time();
        }

        // Validation des données
        $errors = [];
        if (empty($nom)) {
            $errors[] = "Le nom est requis";
        }
        if (empty($description)) {
            $errors[] = "La description est requise";
        }

        if (empty($errors)) {
            try {
                $query = "INSERT INTO demande (nom, url, description) VALUES (:nom, :url, :description)";
                $stmt = $db->prepare($query);

                $stmt->bindParam(":nom", $nom);
                $stmt->bindParam(":url", $url);
                $stmt->bindParam(":description", $description);

                if ($stmt->execute()) {
                    header("Location: demande/" . $url);
                    exit();
                } else {
                    $_SESSION['error'] = "Une erreur est survenue lors de l'insertion.";
                    header("Location: form.php");
                    exit();
                }
            } catch(PDOException $e) {
                $_SESSION['error'] = "Erreur: " . $e->getMessage();
                header("Location: form.php");
                exit();
            }
        } else {
            $_SESSION['errors'] = $errors;
            header("Location: form.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Erreur de connexion à la base de données";
        header("Location: form.php");
        exit();
    }
} else {
    header("Location: form.php");
    exit();
}
?>
