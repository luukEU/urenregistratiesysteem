<?php
require 'config.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Verbinding controleren
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Check of ID aanwezig is
if (!isset($_GET['id'])) {
    die("Geen medewerker-ID opgegeven!");
}
$id = intval($_GET['id']);

// Als formulier verzonden is
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'];
    $tussenvoegsel = $_POST['tussenvoegsel'];
    $geboortedatum = $_POST['geboortedatum'];
    $functie = $_POST['functie'];
    $werkmail = $_POST['werkmail'];
    $kantoorruimte = $_POST['kantoorruimte'];

    $sql = "UPDATE medewerkers SET naam=?, tussenvoegsel=?, geboortedatum=?, functie=?, werkmail=?, kantoorruimte=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Fout bij voorbereiden van de update query: " . $conn->error);
    }
    $stmt->bind_param("ssssssi", $naam, $tussenvoegsel, $geboortedatum, $functie, $werkmail, $kantoorruimte, $id);

    if ($stmt->execute()) {
        header("Location: medewerkersinfo.php");
        exit;
    } else {
        echo "Fout bij bijwerken: " . $stmt->error;
    }
    $stmt->close();
}

// Huidige gegevens ophalen
$sql = "SELECT * FROM medewerkers WHERE id=?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Fout bij voorbereiden van de select query: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();

// Controle of get_result() beschikbaar is
if (method_exists($stmt, 'get_result')) {
    $result = $stmt->get_result()->fetch_assoc();
} else {
    // Fallback als get_result niet beschikbaar is
    $stmt->bind_result($naam, $tussenvoegsel, $geboortedatum, $functie, $werkmail, $kantoorruimte);
    if ($stmt->fetch()) {
        $result = [
            'naam' => $naam,
            'tussenvoegsel' => $tussenvoegsel,
            'geboortedatum' => $geboortedatum,
            'functie' => $functie,
            'werkmail' => $werkmail,
            'kantoorruimte' => $kantoorruimte
        ];
    } else {
        $result = null;
    }
}

$stmt->close();

if (!$result) {
    die("Medewerker met ID $id niet gevonden.");
}

header("Location: aanvrageninfo.php");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="stylesbewerken.css">
    <meta charset="UTF-8">
    <title>Medewerker Bewerken</title>
</head>
<body>

<div class="container">
    <h2>Medewerker Bewerken</h2>
    <form method="post" action="?id=<?= htmlspecialchars($id) ?>">
        <label>Naam:</label>
        <input type="text" name="naam" value="<?= htmlspecialchars($result['naam']) ?>" required>

        <label>Tussenvoegsel:</label>
        <input type="text" name="tussenvoegsel" value="<?= htmlspecialchars($result['tussenvoegsel']) ?>">

        <label>Geboortedatum:</label>
        <input type="date" name="geboortedatum" value="<?= htmlspecialchars($result['geboortedatum']) ?>" required>

        <label>Functie:</label>
        <input type="text" name="functie" value="<?= htmlspecialchars($result['functie']) ?>" required>

        <label>Werkmail:</label>
        <input type="email" name="werkmail" value="<?= htmlspecialchars($result['werkmail']) ?>" required>

        <label>Kantoorruimte:</label>
        <input type="text" name="kantoorruimte" value="<?= htmlspecialchars($result['kantoorruimte']) ?>" required>

        <button type="submit">Opslaan</button>
    </form>
    <p><a href="medewerkersinfo.php">⬅ Terug naar overzicht</a></p>
</div>

<?php $conn->close(); ?>

</body>
</html>
