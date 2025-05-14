<?php
require 'config.php';

if (!isset($_GET['id'])) {
    die("Geen klant-ID opgegeven.");
}

$id = (int) $_GET['id'];

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Gegevens bijwerken
        $sql = "UPDATE klanten SET naam=?, tussenvoegsel=?, bedrijf=?, functie=?, telefoon=?, adres=?, email=?, bericht=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['naam'],
            $_POST['tussenvoegsel'],
            $_POST['bedrijf'],
            $_POST['functie'],
            $_POST['telefoon'],
            $_POST['adres'],
            $_POST['email'],
            $_POST['bericht'],
            $id
        ]);
        echo "Gegevens bijgewerkt. <a href='klantenoverzicht.php'>Terug naar overzicht</a>";
        exit;
    } else {
        // Huidige klantgegevens ophalen
        $stmt = $pdo->prepare("SELECT * FROM klanten WHERE id = ?");
        $stmt->execute([$id]);
        $klant = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$klant) {
            die("Klant niet gevonden.");
        }
    }
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}
?>
<link rel="stylesheet" href="stylesbewerken.css">
<h2>Klantgegevens bewerken</h2>
<form method="post">
    Naam: <input type="text" name="naam" value="<?= htmlspecialchars($klant['naam']) ?>"><br>
    Tussenvoegsel: <input type="text" name="tussenvoegsel" value="<?= htmlspecialchars($klant['tussenvoegsel']) ?>"><br>
    Bedrijf: <input type="text" name="bedrijf" value="<?= htmlspecialchars($klant['bedrijf']) ?>"><br>
    Functie: <input type="text" name="functie" value="<?= htmlspecialchars($klant['functie']) ?>"><br>
    Telefoon: <input type="text" name="telefoon" value="<?= htmlspecialchars($klant['telefoon']) ?>"><br>
    Adres: <input type="text" name="adres" value="<?= htmlspecialchars($klant['adres']) ?>"><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($klant['email']) ?>"><br>
    Bericht: <textarea name="bericht"><?= htmlspecialchars($klant['bericht']) ?></textarea><br>
    <button type="submit">Opslaan</button>
</form>
<p><a href="klanteninfo.php">⬅ Terug naar overzicht</a></p>
