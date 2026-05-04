<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'config.php';

$stmt = $pdo->query("SELECT * FROM clients ORDER BY id");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total = count($clients);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste clients - Ma Plateforme</title>
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
    <h2>Liste des clients</h2>
    <p class="count">Il y a <?= $total ?> client(s) enregistré(s)</p>

    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>nom</th>
                <th>prenom</th>
                <th>age</th>
                <th>adresse</th>
                <th>ville</th>
                <th>mail</th>
                <th>telephone</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($total === 0): ?>
                <tr><td colspan="8">Aucun client enregistré.</td></tr>
            <?php else: ?>
                <?php foreach ($clients as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['nom']) ?></td>
                        <td><?= htmlspecialchars($c['prenom']) ?></td>
                        <td><?= $c['age'] ?></td>
                        <td><?= htmlspecialchars($c['adresse']) ?></td>
                        <td><?= htmlspecialchars($c['ville']) ?></td>
                        <td><?= htmlspecialchars($c['mail']) ?></td>
                        <td><?= htmlspecialchars($c['telephone']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="btn-group">
        <a href="ajouter_client.php" class="btn">Ajouter un client</a>
        <a href="logout.php" class="btn">Quitter</a>
    </div>
</div>

</body>
</html>