<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$nom = $_SESSION['user_nom'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil - Ma Plateforme</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="header-logo">
    <img src="UAC.jpeg" alt="Logo gauche">
    <div class="header-title">Bienvenue sur ma plateforme</div>
    <img src="ENEAM.jpeg" alt="Logo droite">
</div>

<nav>
    <a href="accueil.php">Accueil</a>
    <a href="articles.php">Articles</a>
    <a href="ventes.php">Ventes</a>
    <a href="clients.php">Liste clients</a>
    <a href="logout.php" class="nav-quitter">Quitter</a>
</nav>

<div class="container">
    <div class="welcome-box">
        <h2>Bonjour, <?= htmlspecialchars($nom) ?> !</h2>
        <p>Que souhaitez-vous faire ?</p>
        <a href="articles.php" class="btn">Articles</a>
        <a href="ventes.php" class="btn">Ventes</a>
        <a href="clients.php" class="btn">Liste clients</a>
    </div>
</div>
<footer>
    <a href="Deconnexion.php" class="btn-logout">Se déconnecter</a>
</footer>

</body>
</html>