<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    $stmt = $conn->prepare("SELECT id, wachtwoord, rol FROM gebruikers WHERE gebruikersnaam = ?");
    $stmt->bind_param("s", $gebruikersnaam);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($wachtwoord, $row['wachtwoord'])) {
            $_SESSION['gebruiker_id'] = $row['id'];
            $_SESSION['rol'] = $row['rol'];
            header("Location: urenregistratie.php");
            exit;
        } else {
            $foutmelding = "Ongeldig wachtwoord.";
        }
    } else {
        $foutmelding = "Gebruiker niet gevonden.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <title>Inloggen</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: url('images/achtergrond.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
    }
    .login-container {
      background-color: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 40px;
      border-radius: 12px;
      width: 400px;
      max-width: 90%;
      text-align: center;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      box-shadow: 0 5px 20px rgba(0,0,0,0.5);
    }
    input[type="text"], input[type="password"] {
      width: 90%;
      padding: 15px;
      margin: 15px 0;
      border: none;
      border-radius: 8px;
      font-size: 16px;
    }
    button {
      background-color: #007bff;
      color: white;
      padding: 15px 30px;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      cursor: pointer;
      margin-top: 10px;
    }
    button:hover {
      background-color: #0056b3;
    }
    .fout {
      color: #ff6666;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Inloggen</h2>
    <form method="POST">
      <input type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" required><br>
      <input type="password" name="wachtwoord" placeholder="Wachtwoord" required><br>
      <button type="submit">Inloggen</button>
    </form>
    <?php if (isset($foutmelding)) { echo "<p class='fout'>$foutmelding</p>"; } ?>
  </div>
</body>
</html>
