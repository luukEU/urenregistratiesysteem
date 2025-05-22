<?php
require 'config.php';
session_start();

// Controleer of gebruiker is ingelogd
if (!isset($_SESSION['gebruiker_id']) || !isset($_SESSION['username'])) {
    header("Location: inlog.php");
    exit;
}

$gebruiker_id = $_SESSION['gebruiker_id'];
$username = $_SESSION['username'];

// Verwerking formulier bij POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $klantnaam = $_POST['klantnaam'];
    $titel = $_POST['titel'];
    $omschrijving = $_POST['omschrijving'];
    $aanvraagdatum = $_POST['aanvraagdatum'];
    $kennis = $_POST['kennis'];

    include 'config.php';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Verbinding mislukt: " . $conn->connect_error);
    }

    $sql = "INSERT INTO aanvragen (klantnaam, titel, omschrijving, aanvraagdatum, kennis) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $klantnaam, $titel, $omschrijving, $aanvraagdatum, $kennis);

    if ($stmt->execute()) {
        header("Location: aanvrageninfo.php");
        exit;
    } else {
        echo "Fout bij opslaan: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .navbar {
            width: 100%;
            background: #222;
            padding: 15px;
            text-align: left;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        .navbar img {
            height: 40px;
            width: auto;
            margin-left: auto;
        }

        .container {
            background: rgba(34, 34, 34, 0.9);
            color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
            text-align: center;
            margin-top: 80px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: white;
            text-align: left;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.3s ease-in-out;
            background: #333;
            color: white;
        }
        input:focus, textarea:focus {
            outline: none;
            background: #444;
        }
        textarea {
            resize: none;
            height: 100px;
        }

        button {
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            transition: 0.3s ease-in-out;
        }
        button:hover {
            background: #218838;
        }

        @media (max-width: 768px) {
            .container {
                width: 100%;
                max-width: 90%;
                padding: 20px;
            }
            body {
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .navbar a {
                font-size: 14px;
                padding: 8px 15px;
            }
            .container {
                width: 95%;
                padding: 15px;
            }
            button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<script src="zoekfunctie.js"></script>
<body>
    <div class="navbar">
        <a href="hoofdpagina.php">⬅ Terug naar Home</a>
        <a href="klanteninfo.php">
            <img src="images/devopslogo.png" alt="Home" class="home-logo">
        </a>
    </div>

    <div class="container">
        <h2>Lopende Aanvragen</h2>
        <form method="POST">
            <label for="klantnaam">Klantnaam:</label>
            <input type="text" id="klantnaam" name="klantnaam" placeholder="Naam van de klant" required>

            <label for="titel">Titel van aanvraag:</label>
            <input type="text" id="titel" name="titel" placeholder="Titel van de aanvraag" required>

            <label for="omschrijving">Omschrijving van aanvraag:</label>
            <textarea id="omschrijving" name="omschrijving" placeholder="Omschrijf de aanvraag..." required></textarea>

            <label for="aanvraagdatum">Aanvraagdatum:</label>
            <input type="date" id="aanvraagdatum" name="aanvraagdatum" required>

            <label for="kennis">Benodigde kennis:</label>
            <input type="text" id="kennis" name="kennis" placeholder="Vereiste kennis voor de aanvraag" required>

            <button type="submit">Verzenden</button>
        </form>
    </div>
</body>
</html>
