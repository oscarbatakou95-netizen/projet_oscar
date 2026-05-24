<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'config.php';

$erreur = "";
$succes = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $age = trim($_POST['age'] ?? '');
    $adresse = trim($_POST['adresse'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $mail = trim($_POST['mail'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    if (empty($nom) || empty($prenom)) {
        $erreur = "Le nom et le prénom sont obligatoires !";
    } else {
        $stmt = $pdo->prepare("INSERT INTO clients (nom, prenom, age, adresse, ville, mail, telephone) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $age, $adresse, $ville, $mail, $telephone]);
        $succes = "Client ajouté avec succès !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un client - Ma Plateforme</title>
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
    <div class="form-box">
        <h2>Ajouter un client</h2>
        <h3>Informations du client</h3>

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
                <label>Âge :</label>
                <input type="number" name="age" value="<?= htmlspecialchars($_POST['age'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Adresse :</label>
                <input type="text" name="adresse" value="<?= htmlspecialchars($_POST['adresse'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Ville :</label>
                <input type="text" name="ville" value="<?= htmlspecialchars($_POST['ville'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Mail :</label>
                <input type="email" name="mail" value="<?= htmlspecialchars($_POST['mail'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Téléphone :</label>
                <input type="text" name="telephone" value="<?= htmlspecialchars($_POST['telephone'] ?? '') ?>">
            </div>
            <div class="btn-group">
                <input type="reset" class="btn" value="Effacer">
                <input type="submit" class="btn" value="Ajouter">
                <a href="clients.php" class="btn">Retour</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
