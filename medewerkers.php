<?php
require 'config.php';

// Maak verbinding met de database
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verkrijg de waarden uit het formulier
    $naam = $_POST['naam'];
    $geboortedatum = $_POST['geboortedatum'];
    $functie = $_POST['functie'];
    $werkmail = $_POST['werkmail'];
    $kantoorruimte = $_POST['kantoorruimte'];

    // SQL query om gegevens in de medewerkers tabel in te voegen
    $sql = "INSERT INTO medewerkers (naam, geboortedatum, functie, werkmail, kantoorruimte)
            VALUES ('$naam',  '$geboortedatum', '$functie', '$werkmail', '$kantoorruimte')";

    // Voer de query uit en controleer of de invoer succesvol was
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Gegevens succesvol opgeslagen!'); window.location.href = 'medewerkersinfo.php';</script>";
    } else {
        echo "Fout: " . $sql . "<br>" . $conn->error;
    }
}


// Sluit de databaseverbinding
$conn->close();
?>
