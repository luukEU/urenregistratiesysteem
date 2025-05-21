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
        /* Algemene stijlen */
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

        .navbar img {
            height: 40px;  /* Pas de grootte van het logo aan */
            width: auto;
            margin-left: auto; /* Zorgt ervoor dat het logo rechts komt */
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        .navbar button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .navbar button:hover {
            background-color: #0056b3;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            margin-top: 100px; /* ruimte boven de container vanwege de fixed navbar */
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
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
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Knop 'Toevoegen' */
        .add-btn-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .add-btn {
            padding: 10px 20px;
            background-color: #5cb85c; /* Groene knop */
            color: white;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .add-btn:hover {
            background-color: #4cae4c;
        }

        /* Responsieve stijlen */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            .navbar {
                padding: 10px;
                flex-direction: column;
                align-items: flex-start;
            }

            h1 {
                font-size: 24px;
            }

            table {
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }

            button {
                font-size: 14px;
                padding: 8px 16px;
            }

            .add-btn {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .navbar a {
                font-size: 14px;
                padding: 8px 15px;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 6px;
            }

            .add-btn {
                font-size: 12px;
                padding: 8px 16px;
            }

            button {
                font-size: 12px;
                padding: 8px 16px;
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
<script src="zoekfunctie.js"></script> <!-- Voeg het JavaScript-bestand hier toe -->

<body>

<div class="navbar">
    <a href="hoofdpagina.php">⬅ Terug naar Home</a>
    <img src="images/devopslogo.png" alt="Logo"> <!-- Logo toegevoegd aan de navigatiebalk -->
    <button onclick="window.print()">PDF omzetten</button>
</div>
<img src="images/logo.png" alt="Mijn Logo" class="logo">

<div class="container">
    <h1>Klanten Overzicht</h1>
    <div class="add-btn-container">
        <a href="klanten.html"><button class="add-btn">Toevoegen</button></a>
    </div>
    <input type="text" id="zoekveld" placeholder="Zoek naar naam, project, omschrijving..." onkeyup="zoekInTabel()" style="width: 90%; margin: 10px 5%; padding: 8px; font-size: 16px; border-radius: 5px;">



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
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $sql = "SELECT * FROM klanten";
                $stmt = $pdo->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['naam']) . "</td>
                            <td>" . htmlspecialchars($row['tussenvoegsel']) . "</td>
                            <td>" . htmlspecialchars($row['bedrijf']) . "</td>
                            <td>" . htmlspecialchars($row['functie']) . "</td>
                            <td>" . htmlspecialchars($row['telefoon']) . "</td>
                            <td>" . htmlspecialchars($row['adres']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . htmlspecialchars($row['bericht']) . "</td>
                                <td class='actions-cell'>
                              <a href='klantenbewerken.php?id=" . $row['id'] . "'>
                                <button class='add-btn'>Bewerk</button>
                              </a>
                          </tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='8'>Er is een fout opgetreden: " . $e->getMessage() . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
</div>

</body>
</html>

<?php
$pdo = null; // Sluit de databaseverbinding
?>
