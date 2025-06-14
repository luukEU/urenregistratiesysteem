<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: inlog.php");
    exit;
}
$username = htmlspecialchars($_SESSION['username']);
$email = htmlspecialchars($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Klantenformulier</title>
  <style>
    body {
      background: url('images/Simple chill wallpaper 1920 x 1080 - Wallpaper.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .navbar {
      width: 100%;
      background: #222;
      padding: 15px;
      position: fixed;
      top: 0;
      left: 0;
      box-sizing: border-box;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 5px;
    }

    .navbar a:hover {
      background: #444;
    }

    .home-logo {
      height: 40px;
      margin-right: 10px;
      cursor: pointer;
    }

    .extra-logo {
      height: 40px;
      margin-left: 10px;
      cursor: pointer;
    }

    .center-logos {
      display: flex;
      align-items: center;
    }

    .container {
      background: #222;
      color: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      width: 80%;
      max-width: 350px;
      text-align: center;
      box-sizing: border-box;
      margin-top: 80px;
    }

    h2 {
      text-align: center;
      color: white;
      margin-bottom: 15px;
      font-size: 18px;
    }

    label {
      font-weight: bold;
      display: block;
      margin-top: 8px;
      color: white;
      font-size: 14px;
    }

    input, textarea {
      width: 95%;
      padding: 8px;
      margin-top: 5px;
      border: none;
      border-radius: 6px;
      font-size: 12px;
      background: #333;
      color: white;
      box-sizing: border-box;
    }

    input:focus, textarea:focus {
      outline: none;
      background: #444;
    }

    textarea {
      resize: none;
      height: 80px;
    }

    input[readonly] {
      background: #555;
      cursor: not-allowed;
    }

    button {
      background: #28a745;
      color: white;
      padding: 10px;
      border: none;
      cursor: pointer;
      width: 100%;
      border-radius: 6px;
      font-size: 14px;
      font-weight: bold;
      margin-top: 12px;
    }

    button:hover {
      background: #218838;
    }

    @media (max-width: 600px) {
      .container {
        width: 90%;
        padding: 15px;
      }

      .navbar {
        padding: 10px;
      }
    }

    @media (max-width: 400px) {
      h2 {
        font-size: 16px;
      }

      label {
        font-size: 12px;
      }

      input, textarea {
        font-size: 11px;
      }

      button {
        font-size: 12px;
        padding: 8px;
      }
    }
  </style>
</head>
<body>
  <div class="navbar">
    <a href="hoofdpagina.php">⬅ Terug naar Home</a>
    <div class="center-logos">
      <a href="klanteninfo.php">
        <img src="images/devopslogo.png" alt="Home" class="home-logo">
      </a>
    </div>
  </div>

  <div class="container">
    <h2>Klantenformulier</h2>
    <form action="klanten.php" method="POST">
      <label for="naam">Naam:</label>
      <input type="text" id="naam" name="naam" value="<?php echo $username; ?>" readonly>

      <label for="bedrijf">Bedrijfsnaam:</label>
      <input type="text" id="bedrijf" name="bedrijf" placeholder="Bedrijfsnaam" required>

      <label for="functie">Functie:</label>
      <input type="text" id="functie" name="functie" placeholder="Functie binnen het bedrijf" required>

      <label for="telefoon">Telefoonnummer:</label>
      <input type="text" id="telefoon" name="telefoon" placeholder="Telefoonnummer" required>

      <label for="adres">Adres:</label>
      <input type="text" id="adres" name="adres" placeholder="Straat, huisnummer, postcode, stad" required>

      <label for="email">E-mail:</label>
      <input type="email" id="email" name="email" value="<?php echo $email; ?>" readonly>

      <label for="bericht">Bericht:</label>
      <textarea id="bericht" name="bericht" placeholder="Schrijf hier je bericht..." required></textarea>

      <button type="submit">Verzenden</button>
    </form>
  </div>
</body>
</html>
