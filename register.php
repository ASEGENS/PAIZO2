<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $redirect_url = isset($_POST['redirect_url']) ? $_POST['redirect_url'] : 'auth.php';

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        header("Location: " . $redirect_url . "?message=" . urlencode("Inscription réussie! Vous pouvez maintenant vous connecter."));
    } else {
        header("Location: " . $redirect_url . "?error=" . urlencode("Erreur lors de l'inscription : " . $stmt->error));
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>
