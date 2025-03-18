<?php
session_start();

// Fonction pour authentifier un utilisateur avec Firebase
function authenticateUser($email, $password) {
    $apiKey = "AIzaSyAUtBa95R7_TQgUiCVr4pDCRDFBFSGH4Vo";
    $authUrl = "https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key=" . $apiKey;

    $postData = json_encode([
        "email" => $email,
        "password" => $password,
        "returnSecureToken" => true
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $authUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $responseData = authenticateUser($email, $password);

    if (isset($responseData['idToken'])) {
        $_SESSION['user'] = $responseData;
        header("Location: dashboard.php"); // Redirige vers le tableau de bord
        exit();
    } else {
        $_SESSION['error'] = "Email ou mot de passe incorrect.";
        header("Location: login.php"); // Redirige vers la page de connexion
        exit();
    }
}
?>
