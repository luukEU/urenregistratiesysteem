<?php
session_start();

if (!isset($_SESSION['rol'])) {
    header("Location: inlog.php");
    exit;
}

$rol = $_SESSION['rol'];
$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Urenregistratie</title>
    <style>
        :root {
            --primary-color: #1a73e8;
            --sidebar-bg: #f5f7fa;
            --card-bg: #ffffff;
            --text-color: #333;
            --hover-bg: #e0e7ff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            height: 100vh;
            color: var(--text-color);
            background-color: #f0f2f5;
        }

        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            padding: 30px 20px;
            border-right: 1px solid #ddd;
        }

        .sidebar h2 {
            margin-top: 0;
            font-size: 22px;
            color: var(--primary-color);
        }

        .nav-link {
            display: block;
            padding: 12px 16px;
            margin: 8px 0;
            background-color: transparent;
            border: none;
            width: 100%;
            text-align: left;
            font-size: 16px;
            color: var(--text-color);
            cursor: pointer;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .nav-link:hover {
            background-color: var(--hover-bg);
        }

        .main {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .header {
            margin-bottom: 40px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .card {
            background-color: var(--card-bg);
            padding: 20px 25px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }

        .card h3 {
            margin: 0 0 10px;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            body {
                flex-direction: column;
            }

            .main {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Welkom, <?= $username ?></h2>
        <?php if ($rol === 'afdelingshoofd'): ?>
            <button class="nav-link" onclick="location.href='klanteninfo.php'">Klanten</button>
            <button class="nav-link" onclick="location.href='medewerkersinfo.php'">Medewerkers</button>
            <button class="nav-link" onclick="location.href='aanvrageninfo.php'">Aanvragen</button>
            <button class="nav-link" onclick="location.href='werkzaamhedeninfo.php'">Werkzaamheden</button>
            <button class="nav-link" onclick="location.href='holidays_overview.php'">Feestdagen</button>
            <button class="nav-link" onclick="location.href='jaaroverzicht.php'">Jaaroverzicht</button>

        <?php elseif ($rol === 'medewerker'): ?>
            <button class="nav-link" onclick="location.href='werkzaamhedeninfo.php'">Werkzaamheden</button>
            <button class="nav-link" onclick="location.href='medewerkersinfo.php'">Medewerkers</button>
            <button class="nav-link" onclick="location.href='holidays_overview.php'">Feestdagen</button>

        <?php elseif ($rol === 'klant'): ?>
            <button class="nav-link" onclick="location.href='klanteninfo.php'">Klanten</button>
            <button class="nav-link" onclick="location.href='aanvrageninfo.php'">Aanvragen</button>

        <?php else: ?>
            <p style="color: red;">Onbekende rol.</p>
        <?php endif; ?>
    </div>

    <div class="main">
        <div class="header">
            <h1>Dashboard</h1>
            <p>Beheer eenvoudig je urenregistratie</p>
        </div>

        <div class="card">
            <h3>Welkom terug, <?= $username ?>!</h3>
            <p>Gebruik de navigatie links om je gegevens te beheren.</p>
        </div>
    </div>
</body>
</html>
