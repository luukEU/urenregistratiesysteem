<?php
session_start();
require 'config.php';

$error = "";

// Verbinding maken met de database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Zoek gebruiker + rol
    $sql = "SELECT gebruikers.*, roles.role_name 
            FROM gebruikers 
            JOIN roles ON gebruikers.role_id = roles.id 
            WHERE gebruikers.username = ? OR gebruikers.email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $gebruiker = $result->fetch_assoc();

        if (password_verify($password, $gebruiker['password'])) {
            // Login gelukt
            $_SESSION['gebruiker_id'] = $gebruiker['id'];
            $_SESSION['username'] = $gebruiker['username'];
            $_SESSION['rol'] = strtolower($gebruiker['role_name']);
            $_SESSION['email'] = $gebruiker['email'];

            header("Location: hoofdpagina.php");
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
    <meta charset="UTF-8" />
    <title>Inloggen</title>
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

        .login-container {
            background-color: var(--card-bg);
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            width: 360px;
            text-align: center;
        }

        .login-container h2 {
            margin: 0 0 25px 0;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 24px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 1px solid var(--input-border);
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: var(--input-focus-border);
            box-shadow: 0 0 5px var(--input-focus-border);
        }

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: var(--button-hover-bg);
        }

        .error {
            color: var(--error-color);
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

    <div class="login-container">
        <h2>Inloggen</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="text" name="login" placeholder="Gebruikersnaam of e-mail" required />
            <input type="password" name="password" placeholder="Wachtwoord" required />
            <input type="submit" value="Inloggen" />
        </form>

        <p>Nog geen account? <a href="registratie.php">Registreren</a></p>
    </div>

</body>
</html>
