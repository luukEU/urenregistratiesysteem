<?php
session_start();
require 'config.php';

if (!isset($_SESSION['gebruiker_id'])) {
    die("Niet ingelogd.");
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

$gebruiker_id = $_SESSION['gebruiker_id'];
$id = intval($_GET['id'] ?? 0);

// Check of deze aanvraag bij de gebruiker hoort
$sql = "SELECT * FROM aanvragen WHERE id = ? AND gebruiker_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $gebruiker_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if (!$result) {
    die("Aanvraag niet gevonden of geen toegang.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $klantnaam = $_POST['klantnaam'];
    $titel = $_POST['titel'];
    $omschrijving = $_POST['omschrijving'];
    $aanvraagdatum = $_POST['aanvraagdatum'];
    $kennis = $_POST['kennis'];

    $sql = "UPDATE aanvragen SET klantnaam=?, titel=?, omschrijving=?, aanvraagdatum=?, kennis=? WHERE id=? AND gebruiker_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiii", $klantnaam, $titel, $omschrijving, $aanvraagdatum, $kennis, $id, $gebruiker_id);

    if ($stmt->execute()) {
        header("Location: aanvrageninfo.php");
        exit;
    } else {
        echo "Fout bij bijwerken: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Aanvraag Bewerken</title>
</head>
<body>
    <h2>Aanvraag Bewerken</h2>
    <form method="post">
        Klantnaam: <input type="text" name="klantnaam" value="<?= htmlspecialchars($result['klantnaam']) ?>"><br>
        Titel: <input type="text" name="titel" value="<?= htmlspecialchars($result['titel']) ?>"><br>
        Omschrijving: <input type="text" name="omschrijving" value="<?= htmlspecialchars($result['omschrijving']) ?>"><br>
        Aanvraagdatum: <input type="date" name="aanvraagdatum" value="<?= htmlspecialchars($result['aanvraagdatum']) ?>"><br>
        Kennis: <input type="text" name="kennis" value="<?= htmlspecialchars($result['kennis']) ?>"><br>
        <button type="submit">Opslaan</button>
    </form>
    <a href="aanvrageninfo.php">⬅ Terug</a>
</body>
</html>

<?php $conn->close(); ?>
