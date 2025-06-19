<?php
session_start();
require 'config.php';

// Check of gebruiker is ingelogd
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: inlog.php");
    exit;
}

$gebruiker_id = $_SESSION['gebruiker_id'];

// Haal de rol op voor restrictie
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
$sql = "SELECT role_id FROM gebruikers WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $gebruiker_id);
$stmt->execute();
$stmt->bind_result($role_id);
$stmt->fetch();
$stmt->close();

if ($role_id != 2) {
    die("Je hebt geen toestemming om deze pagina te bekijken.");
}

if (!isset($_GET['id'])) {
    die("Geen klant geselecteerd.");
}
$klant_id = intval($_GET['id']);

// Haal klantgegevens op
$sql = "SELECT * FROM klanten WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $klant_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Klant niet gevonden.");
}
$klant = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Factuurgegevens
$factuurNummer = "FCT-" . date("Ymd") . "-" . $klant_id;
$datum = date("d-m-Y");
$bedrijfsnaam = "GildeDevOps";
$bedrijfsadres = "Bredeweg 235";
$bedrijfstelefoon = "088 468 2000";
$bedrijfsemail = "DevOps@Gilde.nl";

// Formulierverwerking
$omschrijving = isset($_POST['omschrijving']) ? $_POST['omschrijving'] : '';
$bedrag = isset($_POST['bedrag']) ? $_POST['bedrag'] : '';
$factuurIsVerzonden = false;
$mailmelding = '';

function euro($val) {
    return '&euro; ' . number_format((float)$val, 2, ',', '.');
}

// Voor de sier: Toon een succesmelding, maar stuur geen echte mail
if (!empty($omschrijving) && !empty($bedrag)) {
    $to = $klant['email'];
$mailmelding = "<div style='background:#d4edda;color:#155724;padding:15px;border-radius:8px;margin-bottom:25px;'>De factuur is succesvol naar <b>" . htmlspecialchars($to) . "</b> verstuurd!</div>";
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Factuur <?= htmlspecialchars($factuurNummer) ?></title>
    <style>
        :root {
            --primary-color: #1a73e8;
            --sidebar-bg: #f5f7fa;
            --card-bg: #ffffff;
            --text-color: #333;
            --border-color: #ddd;
            --hover-bg: #e0e7ff;
            --button-bg: #1a73e8;
            --button-hover-bg: #155ab6;
        }
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--sidebar-bg);
            color: var(--text-color);
            min-height: 100vh;
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
        .navbar button {
            background-color: var(--button-bg);
            border: none;
            color: white;
            padding: 10px 18px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }
        .navbar button:hover {
            background-color: var(--button-hover-bg);
        }
        .factuur-container {
            max-width: 800px;
            margin: 40px auto 60px auto;
            background-color: var(--card-bg);
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            padding: 35px 40px;
        }
        h1 {
            text-align: center;
            color: var(--primary-color);
            font-size: 30px;
            margin-bottom: 30px;
            margin-top: 0;
        }
        .factuur-info, .klant-info, .bedrijf-info {
            margin-bottom: 30px;
        }
        .factuur-row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        .bedrijf-info, .klant-info {
            width: 48%;
        }
        .factuur-label {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            font-size: 16px;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
            text-align: left;
        }
        th {
            background-color: var(--primary-color);
            color: white;
        }
        .totaal {
            font-weight: bold;
            font-size: 18px;
        }
        .print-btn {
            display: block;
            margin: 35px auto 0 auto;
            background-color: var(--button-bg);
            color: white;
            border: none;
            padding: 14px 36px;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .print-btn:hover {
            background-color: var(--button-hover-bg);
        }
        .factuur-form {
            max-width: 400px;
            margin: 40px auto;
            background: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            padding: 30px 28px 22px 28px;
        }
        .factuur-form label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }
        .factuur-form input, .factuur-form textarea {
            width: 100%;
            padding: 10px 12px;
            font-size: 16px;
            margin-bottom: 18px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }
        .factuur-form button {
            background-color: var(--button-bg);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .factuur-form button:hover {
            background-color: var(--button-hover-bg);
        }
        @media (max-width: 900px) {
            .factuur-container {
                padding: 20px 10px;
            }
            .bedrijf-info, .klant-info {
                width: 100%;
            }
            .factuur-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="klanteninfo.php">⬅ Terug naar Klanten</a>
        <img src="images/devopslogo.png" alt="Logo">
        <button onclick="window.print()">PDF/Print</button>
    </div>

    <?php if (!empty($mailmelding)) echo $mailmelding; ?>

    <?php if (empty($omschrijving) || empty($bedrag)) : ?>
        <form class="factuur-form" method="post">
            <h2 style="text-align:center;color:var(--primary-color);margin-top:0;">Factuur aanmaken</h2>
            <label for="omschrijving">Omschrijving</label>
            <textarea name="omschrijving" id="omschrijving" required rows="3" placeholder="Bijvoorbeeld: Uren softwareontwikkeling"><?= htmlspecialchars($omschrijving) ?></textarea>
            <label for="bedrag">Bedrag (&euro;)</label>
            <input type="number" step="5" min="0" name="bedrag" id="bedrag" required value="<?= htmlspecialchars($bedrag) ?>">
            <button type="submit">Factuur genereren & mailen</button>
        </form>
    <?php else : ?>
        <div class="factuur-container">
            <h1>Factuur</h1>
            <div class="factuur-info factuur-row">
                <div class="bedrijf-info">
                    <div class="factuur-label"><?= htmlspecialchars($bedrijfsnaam) ?></div>
                    <div><?= htmlspecialchars($bedrijfsadres) ?></div>
                    <div>Tel: <?= htmlspecialchars($bedrijfstelefoon) ?></div>
                    <div>Email: <?= htmlspecialchars($bedrijfsemail) ?></div>
                </div>
                <div class="klant-info">
                    <div class="factuur-label">Factuur aan:</div>
                    <div><?= htmlspecialchars($klant['naam']) ?></div>
                    <div><?= htmlspecialchars($klant['bedrijf']) ?></div>
                    <div><?= htmlspecialchars($klant['adres']) ?></div>
                    <div><?= htmlspecialchars($klant['email']) ?></div>
                    <div><?= htmlspecialchars($klant['telefoon']) ?></div>
                </div>
            </div>
            <div style="margin-bottom: 18px;">
                <strong>Factuurnummer:</strong> <?= htmlspecialchars($factuurNummer) ?><br>
                <strong>Datum:</strong> <?= htmlspecialchars($datum) ?>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Omschrijving</th>
                        <th>Bedrag</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= htmlspecialchars($omschrijving) ?></td>
                        <td><?= euro($bedrag) ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="totaal">Totaal</td>
                        <td class="totaal"><?= euro($bedrag) ?></td>
                    </tr>
                </tfoot>
            </table>
            <button class="print-btn" onclick="window.print()">Print / Download als PDF</button>
        </div>
    <?php endif; ?>
</body>
</html>