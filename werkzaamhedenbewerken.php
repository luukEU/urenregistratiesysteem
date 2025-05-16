<?php
require 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) die("Verbinding mislukt: " . $conn->connect_error);

$id = intval($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aantal_uren = $_POST['aantal_uren'];
    $projectnaam = $_POST['projectnaam'];
    $omschrijving = $_POST['omschrijving'];
    $datum_input = $_POST['datum'];

    // Zet input van datetime-local om naar het juiste formaat voor MySQL DATETIME
    $datum = date('Y-m-d H:i:s', strtotime($datum_input));

    $sql = "UPDATE werkzaamheden SET 
        aantal_uren=?, projectnaam=?, omschrijving=?, datum=? 
        WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dsssi", $aantal_uren, $projectnaam, $omschrijving, $datum, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: werkzaamhedeninfo.php"); // Terug naar overzichtspagina
    exit;
} else {
    $stmt = $conn->prepare("SELECT * FROM werkzaamheden WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="stylesbewerken.css">
    <title>Werkzaamheid Bewerken</title>
</head>
<body>
    <h2>Werkzaamheid Bewerken</h2>
    <form method="post">
        Aantal uren: <input type="number" step="0.1" name="aantal_uren" value="<?= htmlspecialchars($result['aantal_uren']) ?>"><br>
        Projectnaam: <input type="text" name="projectnaam" value="<?= htmlspecialchars($result['projectnaam']) ?>"><br>
        Omschrijving: <input type="text" name="omschrijving" value="<?= htmlspecialchars($result['omschrijving']) ?>"><br>

        <?php
        // Als er een datum is in de database, gebruik die, anders de huidige datum en tijd
        if (!empty($result['datum'])) {
            $formattedDateTime = date('Y-m-d\TH:i', strtotime($result['datum']));
        } else {
            $formattedDateTime = date('Y-m-d\TH:i');  // Huidige datum en tijd invullen
        }
        ?>
        Datum & tijd: <input type="datetime-local" name="datum" value="<?= htmlspecialchars($formattedDateTime) ?>"><br><br>

        <button type="submit">Opslaan</button>
    </form>
    <p><a href="werkzaamhedeninfo.php">⬅ Terug naar overzicht</a></p>
</body>
</html>

<?php $conn->close(); ?>
