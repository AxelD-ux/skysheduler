<?php
// Configuration de la connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=skysheduler';
$user = 'root';
$password = 'root';

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    if (strlen($password) < 8) {
        die("Le mot de passe doit comporter au moins 8 caractères.");
    }

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->fetch()) {
        die("Cet email est déjà utilisé.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $verification_code = bin2hex(random_bytes(32)); // Génération d'un code unique

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, verification_code) VALUES (:username, :email, :password, :verification_code)");
    $stmt->execute(['username' => $username, 'email' => $email, 'password' => $hashed_password, 'verification_code' => $verification_code]);

    // Lien de vérification
    $verification_link = "http://localhost/verify.php?code=$verification_code";

    // Envoi de l'email de vérification
    $subject = "Vérification de votre compte";
    $message = "Cliquez sur le lien suivant pour vérifier votre compte : $verification_link";
    $headers = "From: no-reply@tonsite.com";

    if (mail($email, $subject, $message, $headers)) {
        echo "Un email de vérification a été envoyé à votre adresse.";
    } else {
        echo "Erreur lors de l'envoi de l'email.";
    }
}
?>
