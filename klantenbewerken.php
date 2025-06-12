<?php
require 'config.php';
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindingscontrole
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Controleren of er een ID is meegegeven
if (!isset($_GET['id'])) {
    die("Geen klant-ID opgegeven!");
}
$id = intval($_GET['id']);

// Als er een formulier is ingediend (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Gegevens uit formulier ophalen
    $naam = $_POST['naam'];
    $bedrijf = $_POST['bedrijf'];
    $functie = $_POST['functie'];
    $telefoon = $_POST['telefoon'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];
    $bericht = $_POST['bericht'];

    // SQL-query voorbereiden voor UPDATE
    $sql = "UPDATE klanten SET naam=?, bedrijf=?, functie=?, telefoon=?, adres=?, email=?, bericht=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $naam, $bedrijf, $functie, $telefoon, $adres, $email, $bericht, $id);

    if ($stmt->execute()) {
        header("Location: klanteninfo.php"); // Pas aan naar jouw overzichtspagina
        exit;
    } else {
        echo "Fout bij bijwerken: " . $stmt->error;
    }

    $stmt->close();
}

// Huidige gegevens ophalen voor invulling formulier
$sql = "SELECT * FROM klanten WHERE id=?";
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
    <title>Klantgegevens Bewerken</title>
    <link rel="stylesheet" href="stylesbewerken.css"> <!-- Zorg dat dit CSS-bestand bestaat -->
</head>
<body>
    <h2>Klantgegevens Bewerken</h2>
    <form method="post" action="?id=<?= $id ?>">
        Naam: <input type="text" name="naam" value="<?= htmlspecialchars($result['naam'] ?? '') ?>"><br>
        Bedrijf: <input type="text" name="bedrijf" value="<?= htmlspecialchars($result['bedrijf'] ?? '') ?>"><br>
        Functie: <input type="text" name="functie" value="<?= htmlspecialchars($result['functie'] ?? '') ?>"><br>
        Telefoon: <input type="text" name="telefoon" value="<?= htmlspecialchars($result['telefoon'] ?? '') ?>"><br>
        Adres: <input type="text" name="adres" value="<?= htmlspecialchars($result['adres'] ?? '') ?>"><br>
        E-mail: <input type="email" name="email" value="<?= htmlspecialchars($result['email'] ?? '') ?>"><br>
        Bericht: <textarea name="bericht"><?= htmlspecialchars($result['bericht'] ?? '') ?></textarea><br><br>
        <button type="submit">Opslaan</button>
    </form>
    <p><a href="klanteninfo.php">⬅ Terug naar overzicht</a></p>
</body>
</html>

<?php $conn->close(); ?>
