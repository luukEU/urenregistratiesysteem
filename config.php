<?php
// Database configuratie
$servername = "localhost"; // Of het IP-adres van je database
$username = "root"; // Je database gebruikersnaam
$password = "Ev1ja2ma3!"; // Je database wachtwoord
$dbname = "klanten_db"; // De naam van je database
$charset = 'utf8';

// Maak de databaseverbinding
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>


