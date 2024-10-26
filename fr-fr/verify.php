<?php
$dsn = 'mysql:host=localhost;dbname=ta_base';
$user = 'ton_utilisateur';
$password = 'ton_motdepasse';

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Vérifie si le code existe
    $stmt = $pdo->prepare("SELECT id FROM users WHERE verification_code = :code AND is_verified = 0");
    $stmt->execute(['code' => $code]);
    $user = $stmt->fetch();

    if ($user) {
        // Met à jour l'utilisateur comme vérifié
        $stmt = $pdo->prepare("UPDATE users SET is_verified = 1, verification_code = NULL WHERE id = :id");
        $stmt->execute(['id' => $user['id']]);
        echo "Compte vérifié avec succès !";
    } else {
        echo "Code de vérification invalide ou compte déjà vérifié.";
    }
}
?>
