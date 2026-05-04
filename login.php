<?php
session_start();
require_once 'config.php';

$erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $mdp = trim($_POST['mot_de_passe'] ?? '');

    if (empty($email) || empty($mdp)) {
        $erreur = "Formulaire à compléter !";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mdp, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_nom'] = $user['nom'];
            header("Location: accueil.php");
            exit;
        } else {
            $erreur = "E-mail ou mot de passe incorrect !";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Ma Plateforme</title>
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
    <div class="form-box">
        <h2>Se connecter</h2>
        <h3>Vos identifiants</h3>

        <?php if ($erreur): ?>
            <p class="error"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>E-mail :</label>
                <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="mot_de_passe">
            </div>
            <div class="btn-group">
                <input type="reset" class="btn" value="Effacer">
                <input type="submit" class="btn" value="Se connecter">
            </div>
        </form>

        <span class="link-small">Pas encore de compte ? <a href="inscription.php">S'inscrire</a></span>
    </div>
</div>

</body>
</html>
