<?php
require 'config.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = $_POST['role_id'];

    // Check of e-mail al bestaat
    $check = $conn->prepare("SELECT id FROM gebruikers WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $error = "Er bestaat al een account met dit e-mailadres.";
    } else {
        // E-mailadres is uniek, account aanmaken
        $stmt = $conn->prepare("INSERT INTO gebruikers (username, email, password, role_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $username, $email, $password, $role_id);

        if ($stmt->execute()) {
            $success = "Account succesvol aangemaakt! Je kunt nu inloggen.";
        } else {
            $error = "Er ging iets mis: " . $stmt->error;
        }

        $stmt->close();
    }

    $check->close();
    $conn->close();
}
?>

<h2>Registreren</h2>

<?php if ($error): ?>
    <p style="color: red;"><?php echo $error; ?></p>
<?php elseif ($success): ?>
    <p style="color: green;"><?php echo $success; ?></p>
<?php endif; ?>

<form method="POST" action="">
    Gebruikersnaam: <input type="text" name="username" required><br>
    E-mail: <input type="email" name="email" required><br>
    Wachtwoord: <input type="password" name="password" required><br>
    Rol:
    <select name="role_id">
        <option value="1">Medewerker</option>
        <option value="2">Afdelingshoofd</option>
    </select><br>
    <input type="submit" value="Account aanmaken">
</form>

<p>Heb je al een account? <a href="inlog.php">Inloggen</a></p>

