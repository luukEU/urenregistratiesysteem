<?php
require 'config.php';
session_start();

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}

$gebruiker_id = $_SESSION['gebruiker_id'];
$aantal_uren = $_POST['aantal_uren'] ?? 0;
$projectnaam = $_POST['projectnaam'] ?? '';
$omschrijving = $_POST['omschrijving'] ?? '';

// Controleer op verplichte velden
if (empty($aantal_uren) || empty($projectnaam) || empty($omschrijving)) {
    echo "Alle verplichte velden moeten ingevuld zijn!";
    exit;
}

// Voeg de gegevens toe aan de database
$query = "INSERT INTO werkzaamheden (gebruiker_id, aantal_uren, projectnaam, omschrijving, datum) 
          VALUES (:gebruiker_id, :aantal_uren, :projectnaam, :omschrijving, NOW())";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':gebruiker_id', $gebruiker_id);
$stmt->bindParam(':aantal_uren', $aantal_uren);
$stmt->bindParam(':projectnaam', $projectnaam);
$stmt->bindParam(':omschrijving', $omschrijving);

if ($stmt->execute()) {
    header("Location: werkzaamhedeninfo.php");
    exit;
} else {
    echo "Fout bij opslaan.";
}
?>
