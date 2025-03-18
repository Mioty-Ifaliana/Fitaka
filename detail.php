<?php
session_start();
require_once 'db_connect.php';

if (isset($_GET['id'])) {
    $demande_id = $_GET['id'];
    
    // Get demande details
    $sql = "SELECT * FROM demande WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $demande_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $demande = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la demande</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Voulez vous obtenir gratuitement <?php echo htmlspecialchars($demande['nom']); ?>?</h4>
                    </div>
                    <div class="card-body">
                        <form action="process_payment.php" method="POST">
                            <input type="hidden" name="demande_id" value="<?php echo $demande_id; ?>">
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
