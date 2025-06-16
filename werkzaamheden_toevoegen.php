<?php
session_start();

// Controleer of gebruiker is ingelogd
if (!isset($_SESSION['gebruiker_id']) || !isset($_SESSION['username'])) {
    header("Location: inlog.php");
    exit;
}

$gebruiker_id = $_SESSION['gebruiker_id'];
$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Werkzaamheden Registratie</title>
<style>
  :root {
    --primary-color: #1a73e8;
    --sidebar-bg: #f5f7fa;
    --card-bg: #ffffff;
    --text-color: #333;
    --border-color: #ddd;
    --input-bg: #f0f4ff;
    --input-focus-bg: #e0e7ff;
    --button-bg: #1a73e8;
    --button-hover-bg: #155ab6;
  }

  * {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: var(--sidebar-bg);
    color: var(--text-color);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .navbar {
    width: 100%;
    background-color: var(--card-bg);
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    padding: 15px 30px;
    display: flex;
    justify-content: flex-start;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 1000;
    border-bottom: 1px solid var(--border-color);
  }

  .navbar a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: color 0.2s ease;
  }

  .navbar a:hover {
    color: var(--button-hover-bg);
    text-decoration: underline;
  }

  .container {
    background-color: var(--card-bg);
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    max-width: 400px;
    width: 90%;
    margin: 80px auto 60px;
    color: var(--text-color);
  }

  h2 {
    margin-top: 0;
    margin-bottom: 25px;
    color: var(--primary-color);
    font-weight: 700;
    font-size: 28px;
    text-align: center;
  }

  label {
    font-weight: 600;
    display: block;
    margin-top: 15px;
    margin-bottom: 6px;
    text-align: left;
  }

  input[type="text"],
  input[type="number"],
  textarea {
    width: 100%;
    padding: 10px 14px;
    font-size: 15px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    background-color: var(--input-bg);
    color: var(--text-color);
    transition: background-color 0.3s ease, border-color 0.3s ease;
    font-family: inherit;
    resize: none;
  }

  input[type="text"]:focus,
  input[type="number"]:focus,
  textarea:focus {
    outline: none;
    background-color: var(--input-focus-bg);
    border-color: var(--primary-color);
  }

  textarea {
    height: 100px;
  }

  button[type="submit"] {
    background-color: var(--button-bg);
    color: white;
    border: none;
    cursor: pointer;
    width: 100%;
    padding: 14px 0;
    font-size: 17px;
    font-weight: 700;
    border-radius: 6px;
    margin-top: 25px;
    transition: background-color 0.3s ease;
  }

  button[type="submit"]:hover {
    background-color: var(--button-hover-bg);
  }

  @media (max-width: 768px) {
    .container {
      width: 95%;
      padding: 25px 20px;
    }

    .navbar a {
      font-size: 14px;
      padding: 8px 12px;
    }
  }

  @media (max-width: 400px) {
    h2 {
      font-size: 24px;
    }

    label {
      font-size: 14px;
    }

    input, textarea {
      font-size: 14px;
    }

    button {
      font-size: 15px;
      padding: 12px 0;
    }
  }
</style>
</head>
<body>
  <div class="navbar">
    <a href="hoofdpagina.php">⬅ Terug naar Home</a>
  </div>

  <div class="container">
    <h2>Werkzaamheden Registratie</h2>
    <form action="werkzaamheden.php" method="POST">
      <label for="aantal_uren">Aantal Uren:</label>
      <input type="number" id="aantal_uren" name="aantal_uren" placeholder="Aantal gewerkte uren" required min="0">

      <label for="projectnaam">Projectnaam:</label>
      <input type="text" id="projectnaam" name="projectnaam" placeholder="Naam van het project" required>

      <label for="omschrijving">Omschrijving Werkzaamheden:</label>
      <textarea id="omschrijving" name="omschrijving" placeholder="Omschrijf de werkzaamheden" required></textarea>

      <button type="submit">Verzenden</button>
    </form>
  </div>
</body>
</html>
