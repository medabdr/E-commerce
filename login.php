<?php
require 'db.php';
require 'header.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM utilisateurs WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo "<script>window.location.href='index.php';</script>";
            exit;
        } else {
            $message = "Mot de passe incorrect.";
        }
    } else {
        $message = "Aucun utilisateur trouvé avec cet email.";
    }
}
?>

<div class="auth-card">
    <h2>Connexion</h2>
    <?php if ($message): ?>
        <div class="alert alert-error"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label class="form-label">Mot de passe</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width: 100%;">Se Connecter</button>
    </form>
    <p style="text-align:center; margin-top:1.5rem;">Pas encore de compte ? <a href="register.php" style="color:var(--secondary)">S'inscrire</a></p>
</div>

<?php require 'footer.php'; ?>
