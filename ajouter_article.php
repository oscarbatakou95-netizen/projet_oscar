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
    $id_article = trim($_POST['id_article'] ?? '');
    $designation = trim($_POST['designation'] ?? '');
    $prix = trim($_POST['prix'] ?? '');
    $categorie = trim($_POST['categorie'] ?? '');

    if (empty($id_article) || empty($designation) || empty($prix)) {
        $erreur = "Tous les champs obligatoires doivent être remplis !";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO articles (id_article, designation, prix, categorie) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_article, $designation, $prix, $categorie]);
            $succes = "Article ajouté avec succès !";
        } catch (PDOException $e) {
            $erreur = "Cet ID article existe déjà !";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un article - Ma Plateforme</title>
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
        <h2>Ajouter un article</h2>
        <h3>Informations de l'article</h3>

        <?php if ($erreur): ?>
            <p class="error"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>
        <?php if ($succes): ?>
            <p class="success"><?= htmlspecialchars($succes) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>ID Article :</label>
                <input type="text" name="id_article" value="<?= htmlspecialchars($_POST['id_article'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Désignation :</label>
                <input type="text" name="designation" value="<?= htmlspecialchars($_POST['designation'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Prix :</label>
                <input type="number" step="0.01" name="prix" value="<?= htmlspecialchars($_POST['prix'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label>Catégorie :</label>
                <select name="categorie">
                    <option value="video">video</option>
                    <option value="photo">photo</option>
                    <option value="informatique">informatique</option>
                    <option value="divers">divers</option>
                </select>
            </div>
            <div class="btn-group">
                <input type="reset" class="btn" value="Effacer">
                <input type="submit" class="btn" value="Ajouter">
                <a href="articles.php" class="btn">Retour</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
