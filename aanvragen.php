<?php
// Databaseverbinding
$servername = "localhost"; // Je servernaam (bijv. localhost)
$username = "root";        // Je databasegebruikersnaam
$password = "";            // Je databasewachtwoord
$dbname = "klanten_db";    // Je database naam

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Haal de formulierdata op
    $klantnaam = $_POST['klantnaam'];
    $titel = $_POST['titel'];
    $omschrijving = $_POST['omschrijving'];
    $aanvraagdatum = $_POST['aanvraagdatum'];
    $kennis = $_POST['kennis'];

    // Bereid de SQL-query voor om gegevens in de database in te voegen
    $sql = "INSERT INTO aanvragen (klantnaam, titel, omschrijving, aanvraagdatum, kennis) 
            VALUES ('$klantnaam', '$titel', '$omschrijving', '$aanvraagdatum', '$kennis')";

    // Voer de query uit en controleer op fouten
    if ($conn->query($sql) === TRUE) {
        echo "Aanvraag succesvol ingediend!";
    } else {
        echo "Fout bij het indienen van de aanvraag: " . $conn->error;
    }

    // Sluit de verbinding
    $conn->close();
} else {
    echo "Geen formuliergegevens ontvangen.";
}
?>
