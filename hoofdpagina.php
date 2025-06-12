<?php
session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: inlog.php");
    exit;
}

$rol = $_SESSION['rol']; // 'medewerker', 'afdelingshoofd' of 'klant'
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoofdpagina Urenregistratie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-size: cover;
            color: white;
            background-image: url('images/Simple chill wallpaper 1920 x 1080 - Wallpaper.jpg'); 
            margin: 0;
        }

        .navbar {
            width: 100%;
            background: #222;
            padding: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .navbar img {
            height: 50px;
            width: auto;
        }

        .container {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            margin-top: 100px;
        }

        .nav-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .nav-button {
            padding: 15px;
            width: 180px;
            background: white;
            color: black;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .nav-button:hover {
            background: lightgray;
        }

        @media (max-width: 600px) {
            .nav-button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <img src="images/devopslogo.png" alt="Logo">
    </div>

    <div class="container">
        <h2>Welkom, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Kies een persoonlijke urenregistratie:</p>

        <div class="nav-container">
            <?php if ($rol === 'afdelingshoofd'): ?>
                <button class="nav-button" onclick="location.href='klanteninfo.php'">Klanten</button>
                <button class="nav-button" onclick="location.href='medewerkersinfo.php'">Medewerkers</button>
                <button class="nav-button" onclick="location.href='aanvrageninfo.php'">Aanvragen</button>
                <button class="nav-button" onclick="location.href='werkzaamhedeninfo.php'">Werkzaamheden</button>
                <button class="nav-button" onclick="location.href='holidays_overview.php'">Feestdagen</button>

            <?php elseif ($rol === 'medewerker'): ?>
                <button class="nav-button" onclick="location.href='werkzaamhedeninfo.php'">Werkzaamheden</button>
                <button class="nav-button" onclick="location.href='medewerkersinfo.php'">Medewerkers</button>
                <button class="nav-button" onclick="location.href='holidays_overview.php'">Feestdagen</button>

            <?php elseif ($rol === 'klant'): ?>
                <button class="nav-button" onclick="location.href='klanteninfo.php'">Klanten</button>
                <button class="nav-button" onclick="location.href='aanvrageninfo.php'">Aanvragen</button>

            <?php else: ?>
                <p style="color:red;">Onbekende rol.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
