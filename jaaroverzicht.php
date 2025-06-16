<?php
require 'config.php';
session_start();

// Maak PDO-verbinding
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}

// Ophalen medewerkers
$medewerkers = $pdo->query("SELECT m.gebruiker_id, m.naam FROM medewerkers m JOIN gebruikers g ON m.gebruiker_id = g.id")->fetchAll();

$geselecteerde_id = $_GET['gebruiker_id'] ?? '';
$sort = $_GET['sort'] ?? 'projectnaam';

$projectoverzicht = [];
$totaal_uren = null;
$naam = '';

if ($geselecteerde_id) {
    $stmtNaam = $pdo->prepare("SELECT naam FROM medewerkers WHERE gebruiker_id = :id");
    $stmtNaam->bindParam(':id', $geselecteerde_id);
    $stmtNaam->execute();
    $naam = $stmtNaam->fetchColumn();

    if ($sort === 'totaal') {
        $stmtTotaal = $pdo->prepare("
            SELECT SUM(aantal_uren) AS totaal_uren
            FROM werkzaamheden
            WHERE gebruiker_id = :id AND YEAR(datum) = YEAR(CURDATE())
        ");
        $stmtTotaal->bindParam(':id', $geselecteerde_id);
        $stmtTotaal->execute();
        $totaal_uren = $stmtTotaal->fetchColumn();
    } else {
        $query = "
            SELECT projectnaam, SUM(aantal_uren) AS totaal_uren
            FROM werkzaamheden
            WHERE gebruiker_id = :id AND YEAR(datum) = YEAR(CURDATE())
            GROUP BY projectnaam
            ORDER BY " . ($sort === 'uren' ? 'totaal_uren DESC' : 'projectnaam ASC');

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $geselecteerde_id);
        $stmt->execute();
        $projectoverzicht = $stmt->fetchAll();
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Jaaroverzicht Medewerker</title>
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
            background-color: #f0f2f5;
            color: var(--text-color);
        }

        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            padding: 30px 20px;
            border-right: 1px solid #ddd;
        }

        .sidebar h2 {
            font-size: 20px;
            color: var(--primary-color);
            margin-top: 0;
        }

        .main {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .card {
            background-color: var(--card-bg);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 30px;
        }

        select, button {
            padding: 10px 12px;
            margin-right: 10px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f9fafb;
        }

        .no-data {
            color: red;
            margin-top: 15px;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Medewerker Overzicht</h2>
        <button onclick="window.location.href='hoofdpagina.php'" style="margin-top: 20px;">← Terug naar dashboard</button>
    </div>

    <div class="main">
        <div class="card">
            <h1>Jaaroverzicht per medewerker</h1>
            <form method="GET">
                <label for="gebruiker_id">Selecteer medewerker:</label>
                <select name="gebruiker_id" id="gebruiker_id" required>
                    <option value="">-- Kies een medewerker --</option>
                    <?php foreach ($medewerkers as $medewerker): ?>
                        <option value="<?= htmlspecialchars($medewerker['gebruiker_id']) ?>" <?= $geselecteerde_id == $medewerker['gebruiker_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($medewerker['naam']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="sort">Weergave:</label>
                <select name="sort" id="sort">
                    <option value="projectnaam" <?= $sort === 'projectnaam' ? 'selected' : '' ?>>Per project</option>
                    <option value="uren" <?= $sort === 'uren' ? 'selected' : '' ?>>Per project (op uren)</option>
                    <option value="totaal" <?= $sort === 'totaal' ? 'selected' : '' ?>>Totaal aantal uren</option>
                </select>

                <button type="submit">Toon overzicht</button>
            </form>

            <?php if ($geselecteerde_id): ?>
                <h2>Overzicht voor <?= htmlspecialchars($naam) ?> in <?= date('Y') ?></h2>

                <?php if ($sort === 'totaal'): ?>
                    <p><strong>Totaal gewerkte uren dit jaar:</strong>
                        <?= number_format($totaal_uren ?? 0, 2, ',', '.') ?> uur</p>
                <?php elseif (count($projectoverzicht) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Projectnaam</th>
                                <th>Totaal gewerkte uren</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projectoverzicht as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['projectnaam']) ?></td>
                                    <td><?= number_format($row['totaal_uren'], 2, ',', '.') ?> uur</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="no-data">Geen gegevens gevonden voor deze medewerker in dit jaar.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
