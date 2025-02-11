<?php
// Verbinding maken met de database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "klanten_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Medewerker verwijderen als op ❌ wordt geklikt
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $sql = "DELETE FROM medewerkers WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: medewerkers.php"); // Ververs pagina
        exit();
    } else {
        echo "Fout bij verwijderen: " . $conn->error;
    }
}

// Haal gegevens uit de database
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
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
        }
        .navbar a:hover {
            background: #444;
        }
        .plus-button, .delete-button {
            border: none;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }
        .plus-button {
            background-color: #28a745;
            color: white;
            margin-right: 5px;
        }
        .plus-button:hover {
            background-color: #218838;
        }
        .delete-button {
            background-color: #dc3545;
            color: white;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
        table {
            background: rgba(34, 34, 34, 0.9);
            color: white;
            padding: 20px;
            border-radius: 12px;
            width: 90%;
            max-width: 1000px;
            text-align: center;
            margin-top: 80px;
        }
        table, th, td {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
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
            gap: 5px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.html">⬅ Terug naar Home</a>
    </div>

    <div class="container">
        <center>
            <h2>Medewerkers Overzicht</h2>
        </center>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Naam</th>
                    <th>Tussenvoegsel</th>
                    <th>Geboortedatum</th>
                    <th>Functie</th>
                    <th>Werkmail</th>
                    <th>Kantoorruimte</th>
                    <th>Acties</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row["naam"]) ?></td>
                        <td><?= htmlspecialchars($row["tussenvoegsel"]) ?></td>
                        <td><?= htmlspecialchars($row["geboortedatum"]) ?></td>
                        <td><?= htmlspecialchars($row["functie"]) ?></td>
                        <td><?= htmlspecialchars($row["werkmail"]) ?></td>
                        <td><?= htmlspecialchars($row["kantoorruimte"]) ?></td>
                        <td class="action-buttons">
                            <a href="medewerkers.php?delete_id=<?= $row["id"] ?>">
                                <button class="delete-button">❌ Verwijderen</button>
                            </a>
                            <a href="medewerkers.html">
                                <button class="plus-button">➕ Toevoegen</button>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>Geen medewerkers gevonden.</p>
        <?php endif; ?>

        <?php $conn->close(); ?>
    </div>
</body>
</html>
