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
<style>
    /* Reset de base */
    body, h1, p, a, article, h2 {
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
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .demandes {
        margin-top: 20px;
    }

    article {
        background-color: #111; /* Fond gris très foncé */
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
        border: 1px solid #fff; /* Bordure blanche */
    }

    article h2 {
        font-size: 1.5em;
        margin-bottom: 10px;
    }

    article h2 a {
        color: #fff; /* Texte blanc */
        text-decoration: none;
    }

    article h2 a:hover {
        text-decoration: underline; /* Soulignement au survol */
    }

    article p {
        font-size: 1em;
        color: #ddd; /* Texte gris clair */
    }

    footer {
        margin-top: 50px;
        text-align: center;
        padding: 20px 0;
        border-top: 2px solid #fff; /* Ligne de séparation */
        font-size: 0.9em;
        color: #ddd; /* Texte gris clair */
    }

    /* Style pour les messages de succès et d'erreur */
    p[style*="color: green;"],
    p[style*="color: red;"] {
        background-color: #222; /* Fond gris très foncé */
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    p[style*="color: green;"] {
        border: 1px solid #4CAF50; /* Bordure verte */
        color: #4CAF50; /* Texte vert */
    }

    p[style*="color: red;"] {
        border: 1px solid #ff4444; /* Bordure rouge */
        color: #ff4444; /* Texte rouge */
    }
</style>
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
