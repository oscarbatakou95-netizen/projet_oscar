<?php
// Configuration de la base de données
$host = "sql310.infinityfree.com";
$dbname = "if0_42010333_oscbat";
$user = "if0_42010333";
$password = "WSIAQz1N75FBq";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
