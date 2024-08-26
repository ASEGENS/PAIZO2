<?php
include 'db.php'; // Inclure le fichier de connexion à la base de données
session_start();  // Démarrer la session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'auth.php';

    // Préparer et exécuter la requête SQL pour récupérer le mot de passe haché pour le nom d'utilisateur fourni
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Connexion réussie
            $_SESSION['username'] = $username; // Stocker le nom d'utilisateur dans la session
            header("Location: " . $redirect_url . "?message=" . urlencode("Connexion réussie!") . "&type=success");
        } else {
            // Mot de passe incorrect
            header("Location: " . $redirect_url . "?error=" . urlencode("Mot de passe incorrect.") . "&type=danger");
        }
    } else {
        // Nom d'utilisateur introuvable
        header("Location: " . $redirect_url . "?error=" . urlencode("Nom d'utilisateur introuvable.") . "&type=danger");
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
