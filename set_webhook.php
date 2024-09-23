<?php
// set_webhook.php

include 'config.php';

$webhook_url = 'http://localhost/telegram-php-connexion/webhook.php'; // Remplacez par l'URL réelle de votre webhook

// Appeler l'API Telegram pour définir le webhook
$url = "https://api.telegram.org/bot$telegram_token/setWebhook?url=$webhook_url";

$response = file_get_contents($url);
echo $response;
?>
