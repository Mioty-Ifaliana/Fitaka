<?php
session_start();
require_once 'myCon.php';

if (isset($_GET['id'])) {
    $demande_id = $_GET['id'];
    
    // Get database connection
    $database = new Database();
    $conn = $database->getConnection();
    
    // Get demande details
    $sql = "SELECT * FROM demande WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $demande_id);
    $stmt->execute();
    $demande = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la demande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    /* Reset de base */
    body, h4, p, label, input, button {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    body {
        background-color: #fff; /* Fond blanc */
        color: #000; /* Texte noir */
        line-height: 1.6;
        padding: 20px;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .card {
        background-color: #f9f9f9; /* Fond gris très clair */
        border: 1px solid #ddd; /* Bordure grise */
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Ombre légère */
    }

    .card-header {
        background-color: #eee; /* Fond gris clair */
        padding: 20px;
        border-bottom: 1px solid #ddd; /* Ligne de séparation */
    }

    .card-header h4 {
        font-size: 1.5em;
        font-weight: bold;
        margin: 0;
        color: #000; /* Texte noir */
    }

    .card-body {
        padding: 20px;
    }

    .form-label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #000; /* Texte noir */
    }

    .form-control {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd; /* Bordure grise */
        border-radius: 5px;
        background-color: #fff; /* Fond blanc */
        color: #000; /* Texte noir */
        font-size: 1em;
    }

    .form-control:focus {
        outline: none;
        border-color: #000; /* Bordure noire au focus */
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #000; /* Fond noir */
        color: #fff; /* Texte blanc */
        border: none;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .btn:hover {
        background-color: #fff; /* Fond blanc au survol */
        color: #000; /* Texte noir au survol */
        border: 1px solid #000; /* Bordure noire au survol */
    }
</style>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Voulez vous obtenir gratuitement votre demande<?php echo isset($demande['nom']) ? htmlspecialchars($demande['nom']) : ''; ?>?</h4>
                    </div>
                    <div class="card-body">
                        <form action="success.php" method="POST">
                            <div class="mb-3">
                                <label for="numero_carte" class="form-label">Numéro de carte bancaire</label>
                                <input type="text" class="form-control" id="numero_carte" name="numero_carte" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Entrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>