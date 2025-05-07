<?php
require 'config.php';

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Haal werkzaamheden inclusief datum op
$sql = "SELECT naam, tussenvoegsel, aantal_uren, projectnaam, omschrijving, datum FROM werkzaamheden";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Werkzaamheden Overzicht</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/Simple chill wallpaper 1920 x 1080 - Wallpaper.jpg');
            background-size: cover;
            background-position: center;
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

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }

        .navbar img {
            width: 120px;
            height: auto;
        }

        .navbar .right {
            display: flex;
            align-items: center;
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

        @media print {
            button { 
                display: none;
            }
        }

        .container {
            width: 80%;
            margin: 80px auto 0;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
        }

        table {
            width: 90%;
            margin: 20px 0 20px 5%;
            border-collapse: collapse;
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

        .actions-cell {
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
        }

        .btn {
            padding: 6px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 12px;
        }

        .add-button {
            background-color: #5cb85c;
            color: white;
        }

        .add-button:hover {
            background-color: #4cae4c;
        }

        .delete-button {
            background-color: #d9534f;
            color: white;
        }

        .delete-button:hover {
            background-color: #c9302c;
        }

        .add-btn {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .add-btn a {
            text-decoration: none;
        }

    </style>
</head>
<body>

<div class="navbar">
    <div class="left">
        <a href="index.html">⬅ Terug naar Home</a>
    </div>
    <div class="right">
        <img src="images/devopslogo.png" alt="Logo">
        <button onclick="window.print()">PDF omzetten</button>
    </div>
</div>

<div class="container">
    <h1>Werkzaamheden Overzicht</h1>
    
    <div class="add-btn">
        <a href="werkzaamheden.html"><button class="add-button">Toevoegen</button></a>
    </div>
    
    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Naam Medewerker</th>
                    <th>Tussenvoegsel</th>
                    <th>Aantal Uren</th>
                    <th>Projectnaam</th>
                    <th>Omschrijving Werkzaamheden</th>
                    <th>Datum</th>  <!-- Nieuw datumveld -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>

                        
      <td>" . htmlspecialchars($row['naam']) . "</td>
        <td>" . htmlspecialchars($row['tussenvoegsel']) . "</td>
        <td>" . htmlspecialchars($row['aantal_uren']) . "</td>
        <td>" . htmlspecialchars($row['projectnaam']) . "</td>
        <td>" . htmlspecialchars($row['omschrijving']) . "</td>
        <td>" . htmlspecialchars($row['datum'] ?: date("Y-m-d")) . "</td>

      </tr>";

                    }
                } else {
                    echo "<tr><td colspan='6'>Geen werkzaamheden gevonden</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
