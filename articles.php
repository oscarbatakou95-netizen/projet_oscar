<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM articles ORDER BY id_article");
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($articles);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Articles - Ma Plateforme</title>
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
    <h2>Liste des articles</h2>
    <p class="count">Il y a <?= $total ?> article(s) dans la base</p>

    <table>
        <thead>
            <tr>
                <th>id_article</th>
                <th>designation</th>
                <th>prix</th>
                <th>categorie</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($total === 0): ?>
                <tr><td colspan="4">Aucun article enregistré.</td></tr>
            <?php else: ?>
                <?php foreach ($articles as $a): ?>
                    <tr>
                        <td><?= htmlspecialchars($a['id_article']) ?></td>
                        <td><?= htmlspecialchars($a['designation']) ?></td>
                        <td><?= number_format($a['prix'], 2) ?></td>
                        <td><?= htmlspecialchars($a['categorie']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="btn-group">
        <a href="ajouter_article.php" class="btn">Ajouter un article</a>
        <a href="logout.php" class="btn">Quitter</a>
    </div>
</div>

</body>
</html>
