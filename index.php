<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Plateforme</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="header-logo">
    <img src="UAC.jpeg" alt="Logo gauche">
    <div class="header-title">Bienvenue sur ma plateforme</div>
    <img src="ENEAM.jpeg" alt="Logo droite">
</div>

<nav>
    <a href="index.php">Accueil</a>
    <a href="inscription.php">S'inscrire</a>
</nav>

<div class="container">
    <div class="index-box">
        <p>Veuillez vous inscrire ou vous connecter pour accéder au site.</p>
        <a href="inscription.php" class="btn">S'inscrire</a>
        <a href="login.php" class="btn">Se connecter</a>
    </div>
</div>

</body>
</html>
