<?php
require 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) die("Verbinding mislukt: " . $conn->connect_error);

$id = intval($_GET['id']);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'];
    $tussenvoegsel = $_POST['tussenvoegsel'];
    $aantal_uren = $_POST['aantal_uren'];
    $projectnaam = $_POST['projectnaam'];
    $omschrijving = $_POST['omschrijving'];
    $datum = $_POST['datum'];

    $sql = "UPDATE werkzaamheden SET 
        naam=?, tussenvoegsel=?, aantal_uren=?, projectnaam=?, omschrijving=?, datum=? 
        WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssisssi", $naam, $tussenvoegsel, $aantal_uren, $projectnaam, $omschrijving, $datum, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: werkzaamheden.php"); // Terug naar overzichtspagina
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
        Naam: <input type="text" name="naam" value="<?= htmlspecialchars($result['naam']) ?>"><br>
        Tussenvoegsel: <input type="text" name="tussenvoegsel" value="<?= htmlspecialchars($result['tussenvoegsel']) ?>"><br>
        Aantal uren: <input type="number" name="aantal_uren" value="<?= htmlspecialchars($result['aantal_uren']) ?>"><br>
        Projectnaam: <input type="text" name="projectnaam" value="<?= htmlspecialchars($result['projectnaam']) ?>"><br>
        Omschrijving: <input type="text" name="omschrijving" value="<?= htmlspecialchars($result['omschrijving']) ?>"><br>
        Datum: <input type="date" name="datum" value="<?= htmlspecialchars($result['datum']) ?>"><br><br>
        <button type="submit">Opslaan</button>
    </form>
    <p><a href="werkzaamhedeninfo.php">⬅ Terug naar overzicht</a></p>
</body>
</html>

<?php $conn->close(); ?>
