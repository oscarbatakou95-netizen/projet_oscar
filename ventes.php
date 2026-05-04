<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'config.php';

$stmt = $pdo->query("
    SELECT v.id, c.nom, c.prenom, a.designation, v.quantite, v.date_vente
    FROM ventes v
    JOIN clients c ON v.client_id = c.id
    JOIN articles a ON v.id_article = a.id_article
    ORDER BY v.date_vente DESC
");
$ventes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($ventes);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ventes - Ma Plateforme</title>
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
    <h2>Liste des ventes</h2>
    <p class="count">Il y a <?= $total ?> vente(s) enregistrée(s)</p>

    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>nom</th>
                <th>prenom</th>
                <th>designation</th>
                <th>quantite</th>
                <th>date_vente</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($total === 0): ?>
                <tr><td colspan="6">Aucune vente enregistrée.</td></tr>
            <?php else: ?>
                <?php foreach ($ventes as $v): ?>
                    <tr>
                        <td><?= $v['id'] ?></td>
                        <td><?= htmlspecialchars($v['nom']) ?></td>
                        <td><?= htmlspecialchars($v['prenom']) ?></td>
                        <td><?= htmlspecialchars($v['designation']) ?></td>
                        <td><?= $v['quantite'] ?></td>
                        <td><?= $v['date_vente'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="btn-group">
        <a href="effectuer_vente.php" class="btn">Effectuer une vente</a>
        <a href="logout.php" class="btn">Quitter</a>
    </div>
</div>

</body>
</html>