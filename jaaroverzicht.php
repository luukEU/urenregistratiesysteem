<?php
// jaaroverzicht.php

$servername = "localhost"; // Of het IP-adres van je database
$username = "root"; // Je database gebruikersnaam
$password = ""; // Je database wachtwoord
$dbname = "klanten_db"; // De naam van je database
$charset = 'utf8';


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Databaseverbinding mislukt: " . $e->getMessage());
}

$klanten = $pdo->query("SELECT DISTINCT username FROM gebruikers")->fetchAll(PDO::FETCH_COLUMN);

$jaar = $_GET['jaar'] ?? date('Y');
$maand = $_GET['maand'] ?? '';
$week = $_GET['week'] ?? '';
$klant = $_GET['klant'] ?? '';

$query = "SELECT username, aantal_uren, datum FROM werkzaamheden WHERE YEAR(datum) = :jaar";
$params = ['jaar' => $jaar];

if ($maand) {
    $query .= " AND MONTH(datum) = :maand";
    $params['maand'] = $maand;
}

if ($week) {
    $query .= " AND WEEK(datum, 1) = :week";
    $params['week'] = $week;
}

if ($klant) {
    $query .= " AND username = :klant";
    $params['klant'] = $klant;
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$werkzaamheden = $stmt->fetchAll();

$urenPerKlant = [];
foreach ($werkzaamheden as $werk) {
    $klantnaam = $werk['klantnaam'];
    $uren = $werk['aantal_uren'];
    $urenPerKlant[$klantnaam] = ($urenPerKlant[$klantnaam] ?? 0) + $uren;
}
$totaalUren = array_sum($urenPerKlant);
$uurtarief = 50;
$totaalOpbrengst = $totaalUren * $uurtarief;
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Jaaroverzicht Uren per Klant</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Jaaroverzicht gewerkte uren</h1>
<form method="GET">
    <label>Jaar:</label>
    <select name="jaar">
        <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--) echo "<option value='$i'" . ($jaar == $i ? ' selected' : '') . ">$i</option>"; ?>
    </select>
    <label>Maand:</label>
    <select name="maand">
        <option value="">Alle</option>
        <?php for ($m = 1; $m <= 12; $m++) echo "<option value='$m'" . ($maand == $m ? ' selected' : '') . ">" . date('F', mktime(0,0,0,$m,10)) . "</option>"; ?>
    </select>
    <label>Week:</label>
    <select name="week">
        <option value="">Alle</option>
        <?php for ($w = 1; $w <= 53; $w++) echo "<option value='$w'" . ($week == $w ? ' selected' : '') . ">Week $w</option>"; ?>
    </select>
    <label>Klant:</label>
    <select name="klant">
        <option value="">Alle</option>
        <?php foreach ($klanten as $k) echo "<option value='$k'" . ($klant == $k ? ' selected' : '') . ">$k</option>"; ?>
    </select>
    <button type="submit">Filter</button>
</form>

<h2>Resultaten</h2>
<p><strong>Totaal gewerkte uren:</strong> <?= $totaalUren ?> uur</p>
<p><strong>Totaal opbrengst:</strong> &euro;<?= number_format($totaalOpbrengst, 2, ',', '.') ?></p>
<canvas id="urenChart" width="400" height="200"></canvas>
<script>
    const ctx = document.getElementById('urenChart').getContext('2d');
    const urenChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($urenPerKlant)) ?>,
            datasets: [{
                label: 'Gewerkte uren',
                data: <?= json_encode(array_values($urenPerKlant)) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Uren'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Klantnaam'
                    }
                }
            }
        }
    });
</script>
</body>
</html>
