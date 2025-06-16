<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: inlog.php");
    exit;
}

$gebruikersnaam = htmlspecialchars($_SESSION['username']);
$gebruikersmail = htmlspecialchars($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Medewerkersformulier</title>
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
        --button-success-bg: #1a73e8;
        --button-success-hover-bg: #155ab6;
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
        justify-content: space-between;
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

    .navbar img {
        height: 40px;
        width: auto;
    }

    .container {
        background-color: var(--card-bg);
        padding: 30px 40px;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        max-width: 450px;
        width: 90%;
        margin: 40px auto 60px;
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
    input[type="email"],
    input[type="date"] {
        width: 100%;
        padding: 10px 14px;
        font-size: 15px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background-color: var(--input-bg);
        color: var(--text-color);
        transition: background-color 0.3s ease, border-color 0.3s ease;
        font-family: inherit;
    }

    input:focus {
        outline: none;
        background-color: var(--input-focus-bg);
        border-color: var(--primary-color);
    }

    input[readonly] {
        background-color: #e8eaf6;
        color: #555;
        cursor: not-allowed;
    }

    button[type="submit"] {
        background-color: var(--button-success-bg);
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
        background-color: var(--button-success-hover-bg);
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
</style>
</head>
<body>
    <div class="navbar">
        <a href="hoofdpagina.php">⬅ Terug naar Home</a>
        <a href="klanteninfo.php">
            <img src="images/devopslogo.png" alt="Home" />
        </a>
    </div>

    <div class="container">
        <h2>Medewerkersformulier</h2>
        <form method="POST" action="medewerkers.php">
            <input type="hidden" name="form_type" value="medewerkers" />

            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" value="<?= $gebruikersnaam ?>" readonly required />

            <label for="geboortedatum">Geboortedatum:</label>
            <input type="date" id="geboortedatum" name="geboortedatum" required />

            <label for="functie">Functie:</label>
            <input type="text" id="functie" name="functie" placeholder="Functie binnen het bedrijf" required />

            <label for="werkmail">Werkmail:</label>
            <input type="email" id="werkmail" name="werkmail" value="<?= $gebruikersmail ?>" readonly required />

            <label for="kantoorruimte">Kantoorruimte:</label>
            <input type="text" id="kantoorruimte" name="kantoorruimte" placeholder="Bijv. Kamer 202" required />

            <button type="submit">Verzenden</button>
        </form>
    </div>
</body>
</html>
