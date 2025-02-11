<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lopende Aanvragen</title>
    <style>
        body {
            background: url('images/Simple chill wallpaper 1920 x 1080 - Wallpaper.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .navbar {
            width: 100%;
            background: #222;
            padding: 15px;
            text-align: left;
            position: fixed;
            top: 0;
            left: 0;
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
        .container {
            background: rgba(34, 34, 34, 0.9);
            color: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 80%;
            max-width: 800px;
            margin-top: 100px;
        }
        h2 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #333;
        }
        tr:hover {
            background-color: #444;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: white;
        }
        input, textarea {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.3s ease-in-out;
            background: #333;
            color: white;
        }
        input:focus, textarea:focus {
            outline: none;
            background: #444;
        }
        textarea {
            resize: none;
            height: 100px;
        }
        button {
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            transition: 0.3s ease-in-out;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.html">⬅ Terug naar Home</a>
    </div>

    <div class="container">
        <h2>Lopende Aanvragen</h2>

        <!-- Aanvraagformulier -->
        <form action="aanvragen.php" method="POST">
            <label for="klantnaam">Klantnaam:</label>
            <input type="text" id="klantnaam" name="klantnaam" placeholder="Naam van de klant" required>

            <label for="titel">Titel van aanvraag:</label>
            <input type="text" id="titel" name="titel" placeholder="Titel van de aanvraag" required>

            <label for="omschrijving">Omschrijving van aanvraag:</label>
            <textarea id="omschrijving" name="omschrijving" placeholder="Omschrijf de aanvraag..." required></textarea>

            <label for="aanvraagdatum">Aanvraagdatum:</label>
            <input type="date" id="aanvraagdatum" name="aanvraagdatum" required>

            <label for="kennis">Benodigde kennis:</label>
            <input type="text" id="kennis" name="kennis" placeholder="Vereiste kennis voor de aanvraag" required>

            <button type="submit">Verzenden</button>
        </form>

        <!-- Tabel van lopende aanvragen -->
        <h2>Alle aanvragen</h2>
        <table>
            <thead>
                <tr>
                    <th>Klantnaam</th>
                    <th>Titel</th>
                    <th>Omschrijving</th>
                    <th>Aanvraagdatum</th>
                    <th>Kennis</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost"; // Je servernaam (bijv. localhost)
                $username = "root";        // Je databasegebruikersnaam
                $password = "";            // Je databasewachtwoord
                $dbname = "klanten_db";    // Je database naam
                
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Controleren op verbindingse fouten
                if ($conn->connect_error) {
                    die("Verbinding mislukt: " . $conn->connect_error);
                }

                // Query om aanvragen op te halen
                $sql = "SELECT klantnaam, titel, omschrijving, aanvraagdatum, kennis FROM aanvragen";
                $result = $conn->query($sql);

                // Gegevens weergeven in de tabel
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['klantnaam'] . "</td>";
                        echo "<td>" . $row['titel'] . "</td>";
                        echo "<td>" . $row['omschrijving'] . "</td>";
                        echo "<td>" . $row['aanvraagdatum'] . "</td>";
                        echo "<td>" . $row['kennis'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Geen aanvragen gevonden</td></tr>";
                }

                // Verbinding sluiten
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
