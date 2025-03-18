<?php
require_once 'myCon.php';

if (!isset($_GET['url'])) {
    header('Location: /demandes');
    exit();
}

$database = new Database();
$db = $database->getConnection();

if ($db) {
    $url = $_GET['url'];
    $query = "SELECT * FROM demande WHERE url = :url";
    $stmt = $db->prepare($query);
    $stmt->execute([':url' => $url]);
    $demande = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$demande) {
        header('Location: /demandes');
        exit();
    }

    // Définir l'URL canonique
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $canonical = $protocol . $_SERVER['HTTP_HOST'] . '/demande/' . $url;
} else {
    header('Location: /demandes');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($demande['nom']); ?> - FITAKA</title>
    <meta name="description" content="<?php echo htmlspecialchars(substr($demande['description'], 0, 155)); ?>">
    <link rel="canonical" href="<?php echo $canonical; ?>">
</head>
<body>
    <header>
        <nav>
            <a href="/demandes">Retour à la liste</a>
        </nav>
    </header>

    <main>
        <article>
            <h1><?php echo htmlspecialchars($demande['nom']); ?></h1>
            <div class="description">
                <?php echo nl2br(htmlspecialchars($demande['description'])); ?>
            </div>
        </article>
    </main>

    <footer style="margin-top: 50px; text-align: center;">
        <p>&copy; 2025 FITAKA. Tous droits réservés.</p>
    </footer>
</body>
</html>
