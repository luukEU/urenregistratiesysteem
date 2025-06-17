<?php
session_start();
require 'config.php';

// Check of gebruiker is ingelogd
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: inlog.php");
    exit;
}

$gebruiker_id = $_SESSION['gebruiker_id'];

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Haal alleen de klanten op van de ingelogde gebruiker
$sql = "SELECT * FROM klanten WHERE gebruiker_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $gebruiker_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Klanten Overzicht</title>
    <style>
        :root {
            --primary-color: #1a73e8;
            --sidebar-bg: #f5f7fa;
            --card-bg: #ffffff;
            --text-color: #333;
            --border-color: #ddd;
            --hover-bg: #e0e7ff;
            --button-bg: #1a73e8;
            --button-hover-bg: #155ab6;
            --button-success-bg: #1a73e8;
            --button-success-hover-bg: #155ab6;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--sidebar-bg);
            color: var(--text-color);
            min-height: 100vh;
        }

        .navbar {
            width: 100%;
            background-color: var(--card-bg);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid var(--border-color);
        }

        .navbar a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: color 0.2s ease;
        }

        .navbar a:hover {
            color: var(--button-hover-bg);
            text-decoration: underline;
        }

        .navbar img {
            height: 40px;
            width: auto;
        }

        .navbar button {
            background-color: var(--button-bg);
            border: none;
            color: white;
            padding: 10px 18px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }

        .navbar button:hover {
            background-color: var(--button-hover-bg);
        }

        .container {
            max-width: 1100px;
            margin: 40px auto 60px auto;
            background-color: var(--card-bg);
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 30px;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 28px;
            text-align: center;
        }

        .add-btn-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .add-btn {
            background-color: var(--button-success-bg);
            color: white;
            border: none;
            padding: 12px 26px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .add-btn:hover {
            background-color: var(--button-success-hover-bg);
            text-decoration: none;
            color: white;
        }

        #zoekveld {
            width: 90%;
            display: block;
            margin: 0 auto 30px auto;
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: border-color 0.3s ease;
        }

        #zoekveld:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 8px var(--primary-color);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
        }

        th, td {
            padding: 14px 18px;
            border-bottom: 1px solid var(--border-color);
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        tbody tr:hover {
            background-color: var(--hover-bg);
        }

        .button2 {
            background-color: var(--button-success-bg);
            color: white;
            padding: 6px 14px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-weight: 600;
        }

        .button2:hover {
            background-color: var(--button-success-hover-bg);
        }

        @media (max-width: 768px) {
            .container {
                padding: 25px 20px;
                margin: 20px auto 40px auto;
            }

            table, th, td {
                font-size: 14px;
            }

            .add-btn, .button2 {
                font-size: 14px;
                padding: 10px 20px;
            }

            #zoekveld {
                width: 95%;
                font-size: 14px;
                padding: 10px 12px;
            }

            .navbar {
                padding: 10px 20px;
            }
        }

        @media (max-width: 480px) {
            table, th, td {
                font-size: 12px;
            }

            .add-btn, .button2 {
                font-size: 12px;
                padding: 8px 16px;
            }

            #zoekveld {
                font-size: 12px;
                padding: 8px 10px;
            }
        }
    </style>
    <script>
    // Eenvoudige zoekfunctie op de tabel
    function zoekInTabel() {
        var input, filter, table, tr, td, i, j, txtValue, rowVisible;
        input = document.getElementById("zoekveld");
        filter = input.value.toLowerCase();
        table = document.querySelector("table");
        tr = table.getElementsByTagName("tr");
        for (i = 1; i < tr.length; i++) {
            rowVisible = false;
            td = tr[i].getElementsByTagName("td");
            for (j = 0; j < td.length - 1; j++) { // laatste kolom (knoppen) niet zoeken
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        rowVisible = true;
                        break;
                    }
                }
            }
            tr[i].style.display = rowVisible ? "" : "none";
        }
    }
    </script>
</head>

<body>
    <div class="navbar">
        <a href="hoofdpagina.php">⬅ Terug naar Home</a>
        <img src="images/devopslogo.png" alt="Logo">
        <button onclick="window.print()">PDF omzetten</button>
    </div>

    <div class="container">
        <h1>Klanten Overzicht</h1>

        <div class="add-btn-container">
            <a href="klanten_toevoegen.php" class="add-btn">Toevoegen</a>
        </div>

        <input type="text" id="zoekveld" placeholder="Zoek naar naam, bedrijf, functie, ... " onkeyup="zoekInTabel()" />

        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr>
                        <th>Naam</th>
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
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['naam']) . "</td>
                                <td>" . htmlspecialchars($row['bedrijf']) . "</td>
                                <td>" . htmlspecialchars($row['functie']) . "</td>
                                <td>" . htmlspecialchars($row['telefoon']) . "</td>
                                <td>" . htmlspecialchars($row['adres']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['bericht']) . "</td>
                                <td>
                                    <a href='klantenbewerken.php?id=" . $row['id'] . "'>
                                        <button class='button2'>Bewerk</button>
                                    </a>
                                </td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>