<?php
session_start();
$error = "";

// Verbinding maken met de database
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];  // Gebruikersnaam of e-mail
    $password = $_POST['password'];

    // Zoek gebruiker op gebruikersnaam of e-mail
    $sql = "SELECT * FROM gebruikers WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $gebruiker = $result->fetch_assoc();

        if (password_verify($password, $gebruiker['password'])) {
            // Login succesvol
            $_SESSION['gebruiker_id'] = $gebruiker['id'];
            $_SESSION['username'] = $gebruiker['username'];
            $_SESSION['role_id'] = $gebruiker['role_id'];

            // Doorsturen naar dashboard
            header("Location: hoofdpagina.html.");
            exit;
        } else {
            $error = "Ongeldig wachtwoord.";
        }
    } else {
        $error = "Gebruiker niet gevonden.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="nl">
  
<head>
        <title>Inloggen</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="login-container">
<h2>Inloggen</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST" action="">
    Gebruikersnaam of e-mail: <input type="text" name="login" required><br>
    Wachtwoord: <input type="password" name="password" required><br>
    <input type="submit" value="Inloggen">
</form>

<p>Nog geen account? <a href="registratie.php">Registreren</a></p>
</div>
</body>
</html>
