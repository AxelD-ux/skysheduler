<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="inscription.css">
</head>
<body>
    <div class="signup-form">
        <form action="register.php" method="POST" id="signupForm">
            <h2>Inscription</h2>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username" required>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">S'inscrire</button>
        </form>
    </div>
    <script src="script.js">
        // script.js
document.getElementById('signupForm').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    if (password.length < 8) {
        e.preventDefault();
        alert('Le mot de passe doit comporter au moins 8 caractères.');
    }
});

    </script>
</body>
</html>
