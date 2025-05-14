<?php
require 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("Geen medewerker-ID opgegeven.");
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM medewerkers WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    die("Medewerker niet gevonden.");
}

$medewerker = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $naam = $conn->real_escape_string($_POST["naam"]);
    $tussenvoegsel = $conn->real_escape_string($_POST["tussenvoegsel"]);
    $geboortedatum = $conn->real_escape_string($_POST["geboortedatum"]);
    $functie = $conn->real_escape_string($_POST["functie"]);
    $werkmail = $conn->real_escape_string($_POST["werkmail"]);
    $kantoorruimte = $conn->real_escape_string($_POST["kantoorruimte"]);

    $update = "UPDATE medewerkers SET 
        naam='$naam', 
        tussenvoegsel='$tussenvoegsel',
        geboortedatum='$geboortedatum', 
        functie='$functie',
        werkmail='$werkmail',
        kantoorruimte='$kantoorruimte'
        WHERE id=$id";

    if ($conn->query($update) === TRUE) {
        header("Location: medewerkersinfo.php");
        exit;
    } else {
        echo "Fout bij bijwerken: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Medewerker Bewerken</title>
    <style>
        body {
            font-family: Arial;
            background-color: #222;
            color: white;
            padding: 40px;
        }
        input, select {
            padding: 10px;
            width: 300px;
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            margin-top: 20px;
            cursor: pointer;
        }
        a {
            color: #ccc;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Medewerker Bewerken</h1>
    <form method="POST">
        <label>Naam:</label>
        <input type="text" name="naam" value="<?= htmlspecialchars($medewerker['naam']) ?>" required>

        <label>Tussenvoegsel:</label>
        <input type="text" name="tussenvoegsel" value="<?= htmlspecialchars($medewerker['tussenvoegsel']) ?>">

        <label>Geboortedatum:</label>
        <input type="date" name="geboortedatum" value="<?= htmlspecialchars($medewerker['geboortedatum']) ?>" required>

        <label>Functie:</label>
        <input type="text" name="functie" value="<?= htmlspecialchars($medewerker['functie']) ?>" required>

        <label>Werkmail:</label>
        <input type="email" name="werkmail" value="<?= htmlspecialchars($medewerker['werkmail']) ?>" required>

        <label>Kantoorruimte:</label>
        <input type="text" name="kantoorruimte" value="<?= htmlspecialchars($medewerker['kantoorruimte']) ?>" required>

        <button type="submit">Opslaan</button>
    </form>

    <p><a href="medewerkersinfo.php">⬅ Terug naar overzicht</a></p>
</body>
</html>
