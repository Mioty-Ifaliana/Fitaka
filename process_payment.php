<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_carte = $_POST['numero_carte'];
    $demande_id = $_POST['demande_id'];
    
    // Insert payment information
    $sql = "INSERT INTO paiement (numero_carte, demande_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $numero_carte, $demande_id);
    
    if ($stmt->execute()) {
        // Redirect to success page
        header("Location: success.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
