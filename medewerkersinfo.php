<?php 
require 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Haal gegevens uit de database
$sql = "SELECT naam, tussenvoegsel, geboortedatum, functie, werkmail, kantoorruimte FROM medewerkers";
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

        /* Navigatiebalk aanpassing */
        .navbar {
            width: 100%;
            background: #222;
            padding: 15px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between; /* Zorgt ervoor dat de knop en het logo aan de uiterste kanten komen */
            align-items: center;
            z-index: 1000;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            background: #222; /* Kleur van de knop gelijk aan de navbar */
            cursor: pointer;
        }

        .navbar a:hover {
            background: #444;  /* Hover kleur van de knop */
        }

        .navbar img {
            height: 40px; /* Pas de grootte van het logo aan */
            width: auto;
            margin-left: auto; /* Zorgt ervoor dat het logo rechts komt */
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
            justify-content: center; /* Knop in het midden plaatsen */
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

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .delete-button {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="hoofdpagina.html">⬅ Terug naar Home</a>  <!-- Terug naar Home knop met dezelfde stijl als navbar -->
    <img src="images/devopslogo.png" alt="Logo"> <!-- Logo toegevoegd aan de navigatiebalk -->
    <button class="pdf-button" onclick="window.print()">PDF omzetten</button>
</div>

<div class="container">
    <h2>Medewerkers Overzicht</h2>
    <div class="table-container">
        <a href="medewerkers.html" class="add-button">+ Toevoegen</a>
    </div>
    <input type="text" id="zoekInput" onkeyup="zoekTabel()" placeholder="Zoek een medewerker..." style="width: 100%; padding: 10px; margin-bottom: 20px; font-size: 16px; border-radius: 5px;">

    <?php if (isset($result) && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
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
        <td><?= htmlspecialchars($row["id"]) ?></td>
        <td><?= htmlspecialchars($row["naam"]) ?></td>
        <td><?= htmlspecialchars($row["tussenvoegsel"]) ?></td>
        <td><?= htmlspecialchars($row["geboortedatum"]) ?></td>
        <td><?= htmlspecialchars($row["functie"]) ?></td>
        <td><?= htmlspecialchars($row["werkmail"]) ?></td>
        <td><?= htmlspecialchars($row["kantoorruimte"]) ?></td>
    
<td>
    <a href="medewerkersbewerken.php?id=<?= $row['id'] ?>">
        <button class="add-button">Bewerken</button>
    </a>
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
<script>
function zoekTabel() {
    let input = document.getElementById("zoekInput");
    let filter = input.value.toLowerCase();
    let table = document.querySelector("table");
    let tr = table.getElementsByTagName("tr");

    for (let i = 1; i < tr.length; i++) {
        let visible = false;
        let tds = tr[i].getElementsByTagName("td");
        for (let j = 0; j < tds.length; j++) {
            let td = tds[j];
            if (td && td.textContent.toLowerCase().indexOf(filter) > -1) {
                visible = true;
                break;
            }
        }
        tr[i].style.display = visible ? "" : "none";
    }
}
</script>


</body>
</html>
