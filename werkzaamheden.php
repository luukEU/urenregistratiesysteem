<?php
// Database-instellingen
$servername = "localhost";  // Servernaam
$username = "root";         // Pas aan indien nodig
$password = "";             // Pas aan indien nodig
$dbname = "klanten_db";     // Naam van de database

// Verbinding maken met de database
try {
    // PDO-verbinding maken
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Fouten worden weergegeven
} catch (PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}

// Haal de gegevens op uit het formulier (veiligstellen tegen ongeldige of ontbrekende waarden)
$naam = isset($_POST['naam']) ? $_POST['naam'] : '';
$tussenvoegsel = isset($_POST['tussenvoegsel']) ? $_POST['tussenvoegsel'] : '';
$aantal_uren = isset($_POST['aantal_uren']) ? $_POST['aantal_uren'] : 0;
$projectnaam = isset($_POST['projectnaam']) ? $_POST['projectnaam'] : '';
$omschrijving = isset($_POST['omschrijving']) ? $_POST['omschrijving'] : '';

// Controleer of verplichte velden niet leeg zijn
if (empty($naam) || empty($aantal_uren) || empty($projectnaam) || empty($omschrijving)) {
    echo "Alle velden moeten ingevuld zijn!";
    exit;
}

// SQL-query om de gegevens in de database op te slaan
$query = "INSERT INTO werkzaamheden (naam, tussenvoegsel, aantal_uren, projectnaam, omschrijving) 
          VALUES (:naam, :tussenvoegsel, :aantal_uren, :projectnaam, :omschrijving)";

// Voorbereiden van de SQL-statement
$stmt = $pdo->prepare($query);

// Bind de waarden aan de statement
$stmt->bindParam(':naam', $naam);
$stmt->bindParam(':tussenvoegsel', $tussenvoegsel);
$stmt->bindParam(':aantal_uren', $aantal_uren);
$stmt->bindParam(':projectnaam', $projectnaam);
$stmt->bindParam(':omschrijving', $omschrijving);

// Voer de query uit
if ($stmt->execute()) {
    echo "De gegevens zijn succesvol opgeslagen!";
} else {
    echo "Er is een fout opgetreden bij het opslaan van de gegevens.";
}
?>
