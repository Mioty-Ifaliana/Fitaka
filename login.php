<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : "";
unset($_SESSION['error']); // Supprime l'erreur après l'affichage
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
    <h2>Connexion</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    
    <form method="POST" action="auth.php">
        <label>Email :</label>
        <input type="email" name="email" placeholder="admin@gmail.com" required><br><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" placeholder="123456" required><br><br>

        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
