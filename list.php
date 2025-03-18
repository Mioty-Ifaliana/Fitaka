<?php
require_once 'myCon.php';

$database = new Database();
$db = $database->getConnection();
$demandes = [];

if ($db) {
    try {
        $query = "SELECT * FROM demande ORDER BY id DESC";
        $stmt = $db->query($query);
        $demandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $error = "Erreur: " . $e->getMessage();
    }
}

// Définir l'URL canonique
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$canonical = $protocol . $_SERVER['HTTP_HOST'] . '/demandes';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Demandes - FITAKA</title>
    <meta name="description" content="Liste complète des demandes soumises sur FITAKA">
    <link rel="canonical" href="<?php echo $canonical; ?>">
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
        <h1>Liste des Demandes</h1>
        <nav>
            <a href="index.php">À propos</a> |
            <a href="form.php">Nouvelle demande</a>
        </nav>
    </header>

    <main>
        <?php if (isset($_GET['success'])): ?>
            <p style="color: green;">La demande a été ajoutée avec succès!</p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if (empty($demandes)): ?>
            <p>Aucune demande n'a été trouvée.</p>
        <?php else: ?>
            <div class="demandes">
                <?php foreach ($demandes as $demande): ?>
                    <article>
                        <h2>
                            <a href="/demande/<?php echo htmlspecialchars($demande['url']); ?>">
                                <?php echo htmlspecialchars($demande['nom']); ?>
                            </a>
                        </h2>
                        <p><?php echo htmlspecialchars(substr($demande['description'], 0, 200)); ?>...</p>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <footer style="margin-top: 50px; text-align: center;">
        <p>&copy; 2025 FITAKA. Tous droits réservés.</p>
    </footer>
</body>
</html>
