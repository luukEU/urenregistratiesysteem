<?php
// Databaseverbinding
$servername = "localhost";
$username = "root"; // Pas aan als nodig
$password = ""; // Pas aan als nodig
$dbname = "klanten_db";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klanten Overzicht</title>
    <style>
        .navbar {
            width: 100%;
            background: #222;
            padding: 15px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: flex-start;
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
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/Simple chill wallpaper 1920 x 1080 - Wallpaper.jpg');
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            color: #fff;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: white;
        }
        button {
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .delete-button {
            background-color: #d9534f;
        }
        .delete-button:hover {
            background-color: #c9302c;
        }
        .add-button {
            background-color: #5cb85c; /* Groen */
        }
        .add-button:hover {
            background-color: #4cae4c; /* Donkerder groen bij hover */
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="index.html">⬅ Terug naar Home</a>
</div>

<div class="container">
    <h1>Klanten Overzicht</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Tussenvoegsel</th>
                <th>Bedrijf</th>
                <th>Functie</th>
                <th>Telefoon</th>
                <th>Adres</th>
                <th>Email</th>
                <th>Bericht</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Haal gegevens op uit de database en toon in de tabel
            try {
                $sql = "SELECT * FROM klanten";
                $stmt = $pdo->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['naam'] . "</td>
                            <td>" . $row['tussenvoegsel'] . "</td>
                            <td>" . $row['bedrijf'] . "</td>
                            <td>" . $row['functie'] . "</td>
                            <td>" . $row['telefoon'] . "</td>
                            <td>" . $row['adres'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['bericht'] . "</td>
                            <td>
                                <a href='klanten.html'><button class='add-button'>Toevoegen</button></a>
                                <a href='verwijderen.php?id=" . $row['id'] . "'><button class='delete-button'>Verwijderen</button></a>
                            </td>
                          </tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='10'>Er is een fout opgetreden: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
