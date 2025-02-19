<?php
// Database configuratie
$servername = "%"; // Of het IP-adres van je database
$username = "luuk"; // Je database gebruikersnaam
$password = "luuk"; // Je database wachtwoord
$dbname = "klanten_db"; // De naam van je database

// Maak de databaseverbinding
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>


