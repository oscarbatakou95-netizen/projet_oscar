<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'config.php';

$erreur = "";
$succes = "";

// Récupérer la liste des clients et articles pour les selects
$clients = $pdo->query("SELECT id, nom, prenom FROM clients ORDER BY nom")->fetchAll(PDO::FETCH_ASSOC);
$articles = $pdo->query("SELECT id_article, designation, prix FROM articles ORDER BY designation")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id  = trim($_POST['client_id'] ?? '');
    $id_article = trim($_POST['id_article'] ?? '');
    $quantite   = trim($_POST['quantite'] ?? '');
    $date_vente = trim($_POST['date_vente'] ?? '');

    if (empty($client_id) || empty($id_article) || empty($quantite) || empty($date_vente)) {
        $erreur = "Tous les champs sont obligatoires !";
    } elseif ($quantite <= 0) {
        $erreur = "La quantité doit être supérieure à 0 !";
    } else {
        $stmt = $pdo->prepare("INSERT INTO ventes (client_id, id_article, quantite, date_vente) VALUES (?, ?, ?, ?)");
        $stmt->execute([$client_id, $id_article, $quantite, $date_vente]);
        header("Location: ventes.php?succes=1");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Effectuer une vente - Ma Plateforme</title>
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
        <h2>Effectuer une vente</h2>
        <h3>Informations de la vente</h3>

        <?php if ($erreur): ?>
            <p class="error"><?= htmlspecialchars($erreur) ?></p>
        <?php endif; ?>
        <?php if ($succes): ?>
            <p class="success"><?= htmlspecialchars($succes) ?></p>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Client :</label>
                <select name="client_id">
                    <option value="">-- Choisir un client --</option>
                    <?php foreach ($clients as $c): ?>
                        <option value="<?= $c['id'] ?>"
                            <?= (($_POST['client_id'] ?? '') == $c['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['nom'] . ' ' . $c['prenom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Article :</label>
                <select name="id_article">
                    <option value="">-- Choisir un article --</option>
                    <?php foreach ($articles as $a): ?>
                        <option value="<?= $a['id_article'] ?>"
                            <?= (($_POST['id_article'] ?? '') == $a['id_article']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a['designation']) ?> - <?= number_format($a['prix'], 2) ?> €
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Quantité :</label>
                <input type="number" name="quantite" min="1" value="<?= htmlspecialchars($_POST['quantite'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label>Date de vente :</label>
                <input type="date" name="date_vente" value="<?= htmlspecialchars($_POST['date_vente'] ?? date('Y-m-d')) ?>">
            </div>

            <div class="btn-group">
                <input type="reset" class="btn" value="Effacer">
                <input type="submit" class="btn" value="Enregistrer la vente">
                <a href="ventes.php" class="btn">Retour</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
