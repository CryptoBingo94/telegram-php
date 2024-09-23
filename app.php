<?php
// app.php
include 'config.php';

// Récupérer le code de parrainage dans l'URL
$referral_code = isset($_GET['referral_code']) ? $_GET['referral_code'] : '';

if ($referral_code) {
    // Rechercher l'utilisateur par son code de parrainage
    $stmt = $pdo->prepare("SELECT * FROM users WHERE referral_code = ?");
    $stmt->execute([$referral_code]);
    $user = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre code de parrainage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Code de Parrainage</h1>
        <div class="card text-center mt-4">
            <div class="card-body">
                <h2 class="card-title">
                    <?php if ($user): ?>
                        Bienvenue, votre code de parrainage est : <?= $user['referral_code'] ?>
                    <?php else: ?>
                        Code de parrainage non trouvé.
                    <?php endif; ?>
                </h2>
                <p>Partagez ce lien avec vos amis :</p>
                <a href="https://t.me/connexion_phpBot/app?startapp=<?= $referral_code ?>" class="btn btn-primary">Partager</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
