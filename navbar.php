<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img class="rounded" src="img/logo.webp" alt="Logo" style="width: 60px; height: 60px; margin-right: 20px;">
            Pathfinder 2
        </a>        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Accueil</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Personnages
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="commencement.php">Créer un Personnage</a></li>
                        <li><a class="dropdown-item" href="classes.php">Classes</a></li>
                        <li><a class="dropdown-item" href="races.php">Races</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAtlas" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Atlas
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownAtlas">
                        <li><a class="dropdown-item" href="atlas.php">Lore</a></li>
                        <li><a class="dropdown-item" href="atlasmap.php" target="_blank">Carte</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Tuto_PF2e_Foundry.pdf" target="_blank">Tuto Foundry</a>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="account.php"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="auth.php">Connexion / Inscription</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
