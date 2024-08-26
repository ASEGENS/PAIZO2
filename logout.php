<?php
session_start();
session_destroy(); // Détruire toutes les données de session
header("Location: auth.php"); // Rediriger vers la page de connexion
exit();
?>
