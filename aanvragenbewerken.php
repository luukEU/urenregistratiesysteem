<?php
require 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) die("Verbinding mislukt: " . $conn->connect_error);

$id = intval($_GET['id']);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $klantnaam = $_POST['klantnaam'];
    $titel = $_POST['titel'];
    $omschrijving = $_POST['omschrijving'];
    $aanvraagdatum = $_POST['aanvraagdatum'];
    $kennis = $_POST['kennis'];

    $sql = "UPDATE aanvragen SET 
        klantnaam=?, titel=?, omschrijving=?, aanvraagdatum=?, kennis=? 
        WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $klantnaam, $titel, $omschrijving, $aanvraagdatum, $kennis, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: aanvrageninfo.php"); // Terug naar overzichtspagina
    exit;
} else {
    $stmt = $conn->prepare("SELECT * FROM aanvragen WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
   <link rel="stylesheet" href="stylesbewerken.css">
    <title>Aanvraag Bewerken</title>
</head>
<body>
    <h2>Aanvraag Bewerken</h2>
    <form method="post">
        Klantnaam: <input type="text" name="klantnaam" value="<?= htmlspecialchars($result['klantnaam']) ?>"><br>
        Titel: <input type="text" name="titel" value="<?= htmlspecialchars($result['titel']) ?>"><br>
        Omschrijving: <input type="text" name="omschrijving" value="<?= htmlspecialchars($result['omschrijving']) ?>"><br>
        Aanvraagdatum: <input type="date" name="aanvraagdatum" value="<?= htmlspecialchars($result['aanvraagdatum']) ?>"><br>
        Kennis: <input type="text" name="kennis" value="<?= htmlspecialchars($result['kennis']) ?>"><br><br>
        <button type="submit">Opslaan</button>
    </form>
    <p><a href="aanvrageninfo.php">⬅ Terug naar overzicht</a></p>
</body>
</html>

<?php $conn->close(); ?>
