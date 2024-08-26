<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte - Pathfinder 2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <div id="navbar-container"></div>

    <div class="container py-5">
        <h1 class="mb-4">Mon Compte</h1>

        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <h2>Informations de Profil</h2>
        <form action="account.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="new_username" class="form-label">Nom d'utilisateur</label>
                <input type="text" class="form-control" id="new_username" name="new_username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Photo de profil</label>
                <input type="file" class="form-control" id="profile_picture" name="profile_picture">
            </div>
            <button type="submit" name="update_profile" class="btn btn-primary">Mettre à jour le profil</button>
        </form>

        <hr>

        <h2>Changer le mot de passe</h2>
        <form action="account.php" method="post">
            <div class="mb-3">
                <label for="current_password" class="form-label">Mot de passe actuel</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Nouveau mot de passe</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" name="change_password" class="btn btn-primary">Mettre à jour le mot de passe</button>
        </form>

        <hr>

        <!-- Bouton de déconnexion -->
        <form action="logout.php" method="post">
            <button type="submit" class="btn btn-danger">Déconnexion</button>
        </form>
    </div>

    <!-- Footer -->
    <div id="footer-container"></div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <script>
        // Fonction pour charger des fichiers HTML externes
        function loadHTML(elementId, url) {
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById(elementId).innerHTML = data;
                });
        }

        // Charger la navbar et le footer
        document.addEventListener('DOMContentLoaded', function() {
            loadHTML('navbar-container', 'navbar.php');
            loadHTML('footer-container', 'footer.php');
        });
    </script>
</body>
</html>
