<?php
require 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindingscontrole
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Controleren of er een ID is meegegeven
if (!isset($_GET['id'])) {
    die("Geen aanvraag-ID opgegeven!");
}
$id = intval($_GET['id']);

// Als er een formulier is ingediend (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gegevens uit formulier ophalen
    $klantnaam = $_POST['klantnaam'];
    $titel = $_POST['titel'];
    $omschrijving = $_POST['omschrijving'];
    $aanvraagdatum = $_POST['aanvraagdatum'];
    $kennis = $_POST['kennis'];

    // SQL-query voorbereiden voor UPDATE
    $sql = "UPDATE aanvragen SET klantnaam=?, titel=?, omschrijving=?, aanvraagdatum=?, kennis=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $klantnaam, $titel, $omschrijving, $aanvraagdatum, $kennis, $id);

    if ($stmt->execute()) {
        // Terug naar overzicht
        header("Location: aanvrageninfo.php");
        exit;
    } else {
        echo "Fout bij bijwerken: " . $stmt->error;
    }

    $stmt->close();
}

// Huidige gegevens ophalen voor invulling formulier
$sql = "SELECT * FROM aanvragen WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Aanvraag Bewerken</title>
    <link rel="stylesheet" href="stylesbewerken.css">
</head>
<body>
    <h2>Aanvraag Bewerken</h2>
    <form method="post" action="?id=<?= $id ?>">
        Klantnaam: <input type="text" name="klantnaam" value="<?= htmlspecialchars($result['klantnaam'] ?? '') ?>"><br>
        Titel: <input type="text" name="titel" value="<?= htmlspecialchars($result['titel'] ?? '') ?>"><br>
        Omschrijving: <input type="text" name="omschrijving" value="<?= htmlspecialchars($result['omschrijving'] ?? '') ?>"><br>
        Aanvraagdatum: <input type="date" name="aanvraagdatum" value="<?= htmlspecialchars($result['aanvraagdatum'] ?? '') ?>"><br>
        Kennis: <input type="text" name="kennis" value="<?= htmlspecialchars($result['kennis'] ?? '') ?>"><br><br>
        <button type="submit">Opslaan</button>
    </form>
    <p><a href="aanvrageninfo.php">⬅ Terug naar overzicht</a></p>
</body>
</html>

<?php $conn->close(); ?>
