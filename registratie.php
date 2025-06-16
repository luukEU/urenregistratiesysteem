<?php
// Verbinding met de database
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

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Registratie</title>
    <style>
        :root {
            --primary-color: #1a73e8;
            --card-bg: #fff;
            --text-color: #333;
            --input-border: #ccc;
            --input-focus-border: #1a73e8;
            --button-bg: #1a73e8;
            --button-hover-bg: #155ab6;
            --error-color: #e03e3e;
            --success-color: #3ea641;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-color);
        }

        .card {
            background-color: var(--card-bg);
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            width: 360px;
            text-align: center;
        }

        .card h2 {
            margin: 0 0 25px 0;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 24px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 1px solid var(--input-border);
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        select:focus {
            outline: none;
            border-color: var(--input-focus-border);
            box-shadow: 0 0 5px var(--input-focus-border);
        }

        button, input[type="submit"] {
            background-color: var(--button-bg);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 14px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }

        button:hover, input[type="submit"]:hover {
            background-color: var(--button-hover-bg);
        }

        .error {
            color: var(--error-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        .success {
            color: var(--success-color);
            margin-bottom: 15px;
            font-weight: 600;
        }

        p {
            margin-top: 20px;
            font-size: 14px;
        }

        p a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Registreren</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="username" placeholder="Gebruikersnaam" required />
            <input type="email" name="email" placeholder="E-mail" required />
            <input type="password" name="password" placeholder="Wachtwoord" required />
            <select name="role_id" required>
                <option value="1">Medewerker</option>
                <option value="2">Afdelingshoofd</option>
                <option value="3">Klant</option>
            </select>
            <input type="submit" value="Account aanmaken" />
        </form>

        <p>Heb je al een account? <a href="inlog.php">Inloggen</a></p>
    </div>

</body>
</html>
