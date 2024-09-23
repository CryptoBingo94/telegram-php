<?php
// config.php

// Token du bot Telegram (à remplacer par le vôtre)
$telegram_token = '7932021360:AAGI3dcqU9PcGXLc_QVerl2flie2_6bIWU8';

// Informations de connexion à la base de données MySQL
$host = 'localhost';
$dbname = 'telegram_app_php';
$username = 'root';  // Modifiez si nécessaire
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>

