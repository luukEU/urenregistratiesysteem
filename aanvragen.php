<?php
session_start();
require 'config.php';

if (!isset($_SESSION['gebruiker_id'])) {
    die("Niet ingelogd.");
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $klantnaam = $_POST['klantnaam'];
    $titel = $_POST['titel'];
    $omschrijving = $_POST['omschrijving'];
    $aanvraagdatum = $_POST['aanvraagdatum'];
    $kennis = $_POST['kennis'];
    $gebruiker_id = $_SESSION['gebruiker_id'];

    $sql = "INSERT INTO aanvragen (klantnaam, titel, omschrijving, aanvraagdatum, kennis, gebruiker_id) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $klantnaam, $titel, $omschrijving, $aanvraagdatum, $kennis, $gebruiker_id);

    if ($stmt->execute()) {
        echo "<script>alert('Aanvraag succesvol ingediend!'); window.location.href = 'aanvrageninfo.php';</script>";
    } else {
        echo "Fout bij indienen: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Geen formuliergegevens ontvangen.";
}
?>
