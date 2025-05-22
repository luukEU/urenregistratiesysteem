<?php 
require 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Haal gegevens uit de database, inclusief ID
$sql = "SELECT id, naam, tussenvoegsel, geboortedatum, functie, werkmail, kantoorruimte FROM medewerkers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerkers Overzicht</title>
    <style>
        body {
            background: url('images/Simple chill wallpaper 1920 x 1080 - Wallpaper.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: white;
        }

        .navbar {
            width: 100%;
            background: #222;
            padding: 15px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            background: #222;
            cursor: pointer;
        }

        .navbar a:hover {
            background: #444;
        }

        .navbar img {
            height: 40px;
            width: auto;
            margin-left: auto;
        }

        .pdf-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .pdf-button:hover {
            background-color: #0056b3;
        }

        .container {
            width: 80%;
            margin: 100px auto 20px;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
        }

        .table-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .add-button {
            background-color: #28a745;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .add-button:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(34, 34, 34, 0.9);
            color: white;
            padding: 20px;
            border-radius: 12px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
        }

        tr:nth-child(even) {
            background-color: #444;
        }

        tr:hover {
            background-color: #555;
        }

        .actions-cell {
            text-align: center;
        }

        .btn {
               background: #28a745;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background: #218838;
        }
    </style>
</head>
<script src="zoekfunctie.js"></script>

<body>

<div class="navbar">
    <a href="hoofdpagina.php">⬅ Terug naar Home</a>  <!-- Terug naar Home knop met dezelfde stijl als navbar -->
    <img src="images/devopslogo.png" alt="Logo"> <!-- Logo toegevoegd aan de navigatiebalk -->
    <button class="pdf-button" onclick="window.print()">PDF omzetten</button>
</div>

<div class="container">
    <h2>Medewerkers Overzicht</h2>
    <div class="table-container">
        <a href="medewerkers_toevoegen.php" class="add-button">+ Toevoegen</a>
    </div>
    <input type="text" id="zoekveld" placeholder="Zoek naar naam, project, omschrijving..." onkeyup="zoekInTabel()" style="width: 90%; margin: 10px 5%; padding: 8px; font-size: 16px; border-radius: 5px;">

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Tussenvoegsel</th>
                    <th>Geboortedatum</th>
                    <th>Functie</th>
                    <th>Werkmail</th>
                    <th>Kantoorruimte</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row["naam"]) ?></td>
                    <td><?= htmlspecialchars($row["tussenvoegsel"]) ?></td>
                    <td><?= htmlspecialchars($row["geboortedatum"]) ?></td>
                    <td><?= htmlspecialchars($row["functie"]) ?></td>
                    <td><?= htmlspecialchars($row["werkmail"]) ?></td>
                    <td><?= htmlspecialchars($row["kantoorruimte"]) ?></td>
                    <td class="actions-cell">
                        <a href="medewerkersbewerken.php?id=<?= urlencode($row['id']) ?>" class="btn">Bewerk</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Geen medewerkers gevonden.</p>
    <?php endif; ?>
</div>

<?php $conn->close(); ?>

</body>
</html>
