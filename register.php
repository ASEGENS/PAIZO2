<?php
include 'db.php'; // Inclure le fichier de connexion à la base de données
session_start();  // Démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashage du mot de passe
    $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'index.php'; // URL de redirection après l'inscription

    // Préparer et exécuter la requête SQL pour insérer le nouvel utilisateur
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        // Inscription réussie, connecter automatiquement l'utilisateur
        $_SESSION['username'] = $username; // Stocker le nom d'utilisateur dans la session
        header("Location: " . $redirect_url . "?message=" . urlencode("Inscription réussie! Vous êtes maintenant connecté.") . "&type=success");
    } else {
        // Erreur lors de l'inscription
        header("Location: auth.php?error=" . urlencode("Erreur lors de l'inscription : " . $stmt->error) . "&type=danger");
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
