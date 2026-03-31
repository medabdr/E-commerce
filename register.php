<?php
require 'db.php';
require 'header.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    
    $check_query = "SELECT * FROM utilisateurs WHERE email = '$email'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $message = "Email déjà utilisé.";
    } else {
        $insert_query = "INSERT INTO utilisateurs (username, email, password) VALUES ('$username', '$email', '$password')";
        if (mysqli_query($conn, $insert_query)) {
            echo "<script>alert('Inscription réussie ! Vous pouvez vous connecter.'); window.location.href='login.php';</script>";
            exit;
        } else {
            $message = "Erreur lors de l'inscription.";
        }
    }
}
?>

<div class="auth-card">
    <h2>Inscription</h2>
    <?php if ($message): ?>
        <div class="alert alert-error"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label class="form-label">Nom d'utilisateur</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">S'inscrire</button>
    </form>
    <p style="text-align:center; margin-top:1.5rem;">Déjà inscrit ? <a href="login.php" style="color:var(--secondary)">Se connecter</a></p>
</div>

<?php require 'footer.php'; ?>
