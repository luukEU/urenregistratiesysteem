<?php
session_start();

// Controleer of gebruiker is ingelogd
if (!isset($_SESSION['gebruiker_id']) || !isset($_SESSION['username'])) {
    header("Location: inlog.php");
    exit;
}

$gebruiker_id = $_SESSION['gebruiker_id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Werkzaamheden Registratie</title>
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
        }
        .navbar {
            width: 100%;
            background: #222;
            padding: 15px;
            text-align: left;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
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
        .container {
            background: #222;
            color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-sizing: border-box;
        }
        h2 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: white;
        }
        input, textarea {
            width: 95%;
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
        @media (max-width: 600px) {
            .navbar {
                text-align: center;
                padding: 10px 15px;
            }
            .navbar a {
                font-size: 14px;
                padding: 8px 16px;
            }
            .container {
                width: 95%;
                padding: 15px;
                max-width: none;
            }
            h2 {
                font-size: 20px;
            }
            label {
                font-size: 14px;
            }
            input, textarea {
                font-size: 14px;
            }
            button {
                font-size: 14px;
                padding: 10px;
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
