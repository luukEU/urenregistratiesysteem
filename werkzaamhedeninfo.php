<?php
// Database verbinding
$servername = "localhost";
$username = "root"; // Jouw database gebruikersnaam
$password = ""; // Jouw database wachtwoord
$dbname = "klanten_db"; // Jouw database naam

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Verwijder medewerker als de delete-knop is ingedrukt
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    // Gebruik prepared statements om SQL-injecties te voorkomen
    $stmt = $conn->prepare("DELETE FROM werkzaamheden WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('Werkzaamheden succesvol verwijderd!');
                window.location.href = 'view_werkzaamheden.php';
              </script>";
    } else {
        echo "<script>
                alert('Fout bij verwijderen van werkzaamheden.');
                window.location.href = 'view_werkzaamheden.php';
              </script>";
    }
    $stmt->close();
}

// Haal werkzaamheden op
$sql = "SELECT * FROM werkzaamheden";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Werkzaamheden Overzicht</title>
    <style>
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
        .container {
            width: 80%;
            margin: 80px auto 0;
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
        .btn {
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
        }
        .add-button {
            background-color: #5cb85c;
            color: white;
            margin-bottom: 10px;
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
    </style>
</head>
<body>

<div class="navbar">
    <a href="index.html">⬅ Terug naar Home</a>
</div>

<div class="container">
    <h1>Werkzaamheden Overzicht</h1>
    
    <!-- ✅ Toevoegen-knop naar werkzaamheden.html -->
    <a href="werkzaamheden.html"><button class="btn add-button">➕ Toevoegen</button></a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam Medewerker</th>
                <th>Tussenvoegsel</th>
                <th>Aantal Uren</th>
                <th>Projectnaam</th>
                <th>Omschrijving Werkzaamheden</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['naam'] . "</td>
                            <td>" . $row['tussenvoegsel'] . "</td>
                            <td>" . $row['aantal_uren'] . "</td>
                            <td>" . $row['projectnaam'] . "</td>
                            <td>" . $row['omschrijving'] . "</td>
                            <td>
                                <a href='view_werkzaamheden.php?delete=" . $row['id'] . "' onclick='return confirm(\"Weet je zeker dat je deze werkzaamheden wilt verwijderen?\");'>
                                    <button class='btn delete-button'>❌ Verwijderen</button>
                                </a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Geen werkzaamheden gevonden</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
