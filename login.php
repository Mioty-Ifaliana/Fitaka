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
<style>
    /* Reset de base */
    body, h2, p, label, input, button {
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

    h2 {
        font-size: 2em;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
        color: #fff; /* Texte blanc */
        border-bottom: 1px solid #fff; /* Ligne sous le titre */
        padding-bottom: 10px;
    }

    form {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #111; /* Fond gris très foncé */
        border: 1px solid #fff; /* Bordure blanche */
        border-radius: 10px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #fff; /* Texte blanc */
    }

    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #fff; /* Bordure blanche */
        border-radius: 5px;
        background-color: #000; /* Fond noir */
        color: #fff; /* Texte blanc */
        font-size: 1em;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
        outline: none;
        border-color: #fff; /* Bordure blanche au focus */
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

    p[style*="color: red;"] {
        background-color: #222; /* Fond gris très foncé */
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ff4444; /* Bordure rouge */
        margin-bottom: 20px;
        color: #ff4444; /* Texte rouge */
        text-align: center;
    }
</style>
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
