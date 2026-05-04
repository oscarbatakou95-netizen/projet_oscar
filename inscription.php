<?php
session_start();
require_once 'config.php';

$erreur = "";
$succes = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mdp = trim($_POST['mot_de_passe'] ?? '');
    $mdp2 = trim($_POST['mot_de_passe2'] ?? '');

    if (empty($nom) || empty($prenom) || empty($email) || empty($mdp)) {
        $erreur = "Tous les champs sont obligatoires !";
    } elseif ($mdp !== $mdp2) {
        $erreur = "Les mots de passe ne correspondent pas !";
    } else {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $erreur = "Cet e-mail est déjà utilisé !";
        } else {
            $hash = password_hash($mdp, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $email, $hash]);
            $succes = "Inscription réussie ! Vous pouvez vous connecter.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Ma Plateforme</title>
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
    <a href="login.php">Se connecter</a>
</nav>

<div class="container">
    <div class="form-box">
        <h2>S'inscrire</h2>
        <h3>Créer votre compte</h3>

        <?php if ($erreur): ?>
            <p class="error"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>
        <?php if ($succes): ?>
            <p class="success"><?= htmlspecialchars($succes) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Nom :</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Prénom :</label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>E-mail :</label>
                <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="mot_de_passe">
            </div>
            <div class="form-group">
                <label>Confirmer le mot de passe :</label>
                <input type="password" name="mot_de_passe2">
            </div>
            <div class="btn-group">
                <input type="reset" class="btn" value="Effacer">
                <input type="submit" class="btn" value="S'inscrire">
            </div>
        </form>

        <span class="link-small">Déjà un compte ? <a href="login.php">Se connecter</a></span>
    </div>
</div>

</body>
</html>