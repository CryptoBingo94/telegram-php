<?php
// webhook.php

include 'config.php';

// Récupérer les données envoyées par Telegram
$input = file_get_contents('php://input');
$update = json_decode($input, true);

if (isset($update['message'])) {
    $message = $update['message'];
    $chat_id = $message['chat']['id'];
    $invitation_code = ''; // initialiser le code d'invitation

    // Vérifier si l'utilisateur a cliqué sur un lien d'invitation
    if (isset($message['text']) && strpos($message['text'], '/start') === 0) {
        $invitation_code = substr($message['text'], 7); // Récupérer le code du parrain (si présent)
    }

    // Vérifier si l'utilisateur est déjà inscrit
    $stmt = $pdo->prepare("SELECT * FROM users WHERE telegram_id = ?");
    $stmt->execute([$chat_id]);
    $user = $stmt->fetch();

    if (!$user) {
        // Générer un code de parrainage unique pour l'utilisateur
        $referral_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);

        // Inscrire l'utilisateur avec le code du parrain s'il est présent
        $stmt = $pdo->prepare("INSERT INTO users (telegram_id, referral_code, invited_by) VALUES (?, ?, ?)");
        $stmt->execute([$chat_id, $referral_code, $invitation_code]);

        // Lien pour lancer l'application web avec le code de parrainage
        $app_link = "http://localhost/telegram-php-connexion/app.php?referral_code=$referral_code";
        
        // Message de bienvenue avec le lien de lancement de l'application
        $response_text = "Bienvenue ! Cliquez sur le lien ci-dessous pour accéder à l'application :\n";
        $response_text .= "$app_link";
    } else {
        // L'utilisateur existe déjà, on récupère son code de parrainage
        $referral_code = $user['referral_code'];
        
        // Lien de lancement de l'application
        $app_link = "http://localhost/telegram-php-connexion/app.php?referral_code=$referral_code";
        
        // Message de bienvenue
        $response_text = "Bienvenue de retour ! Cliquez sur le lien ci-dessous pour accéder à l'application :\n";
        $response_text .= "$app_link";
    }

    // Envoyer le lien de l'application à l'utilisateur sur Telegram
    $url = "https://api.telegram.org/bot$telegram_token/sendMessage?chat_id=$chat_id&text=" . urlencode($response_text);
    file_get_contents($url);
}
?>
