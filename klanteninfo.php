<?php
require 'config.php';

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
            margin-top: 60px; /* Zorg ervoor dat de container niet onder de fixed navbar zit */
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

        .add-button {
            background-color: #5cb85c; /* Groen */
        }

        .add-btn-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .add-btn {
            float: right;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-add-small {
            background-color: #5cb85c; /* Groene knop */
        }

        button {
            background-color: #007bff; /* Blauwe achtergrond */
            color: white; /* Witte tekst */
            padding: 10px 20px; /* Ruimte rondom tekst */
            font-size: 16px; /* Grotere tekst */
            border: none; /* Geen rand */
            border-radius: 5px; /* Afgeronde hoeken */
            cursor: pointer; /* Hand-icoon bij hover */
        }

        button:hover {
            background-color: #0056b3; /* Donkerdere kleur bij hover */
        }

        @media print {
            button { 
                display: none; /* Verberg knop bij printen */
            }
        }
        .logo {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 50px;  /* Pas de grootte aan */
    height: auto;  /* Zorg dat de verhoudingen behouden blijven */
}

    </style>
</head>
<body>
<div class="navbar">
    <a href="index.html">⬅ Terug naar Home</a>
    <button onclick="window.print()">PDF omzetten</button>
</div>
<img src="images/logo.png" alt="Mijn Logo" class="logo">

<div class="container">
    <div class="add-btn-container">
    </div>
    <h1>Klanten Overzicht</h1>
    <center>

    <a href="klanten.html"><button class="btn-add-small">Toevoegen</button></a>
    </span>
    </center>
    <div style="overflow-x:auto;">
    <table>
        <thead>
            <tr>
               
                <th>Naam</th>
                <th>Tussenvoegsel</th>
                <th>Bedrijf</th>
                <th>Functie</th>
                <th>Telefoon</th>
                <th>Adres</th>
                <th>Email</th>
                <th>Bericht</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $sql = "SELECT * FROM klanten";
                $stmt = $pdo->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                           
                            <td>" . $row['naam'] . "</td>
                            <td>" . $row['tussenvoegsel'] . "</td>
                            <td>" . $row['bedrijf'] . "</td>
                            <td>" . $row['functie'] . "</td>
                            <td>" . $row['telefoon'] . "</td>
                            <td>" . $row['adres'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . $row['bericht'] . "</td>
                            <td>
                                
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
</div>

</body>
</html>
