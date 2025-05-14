<?php
session_start();
require 'config.php';

// Haal JSON-data op uit het POST-verzoek
$data = json_decode(file_get_contents("php://input"), true);

// Controleer of gebruikersnaam en wachtwoord aanwezig zijn
if (!isset($data["gebruikersnaam"]) || !isset($data["wachtwoord"])) {
    echo json_encode(["succes" => false, "melding" => "Gebruikersnaam of wachtwoord ontbreekt."]);
    exit;
}

$gebruikersnaam = $data["gebruikersnaam"];
$wachtwoord = $data["wachtwoord"];

try {
    // Bereid en voer de query uit
    $sql = "SELECT * FROM gebruikers WHERE gebruikersnaam = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $gebruikersnaam);
    $stmt->execute();
    $result = $stmt->get_result();
    $gebruiker = [];
    while($row = $result->fetch_assoc())
    {
        $gebruiker = $row;
    }

    //echo 'gebruiker: ' . 
    //print_r($gebruiker);
    //echo 'wachtwoord formulier: ' . $wachtwoord;
    

    if ($gebruiker && $gebruiker["wachtwoord"] === $wachtwoord) {
        // Wachtwoorden komen overeen → inloggen
        $_SESSION["rol"] = $gebruiker["rol"];
        echo json_encode(["succes" => true, "rol" => $gebruiker["rol"]]);
    } else {
        // Ongeldige inlog
        echo json_encode(["succes" => false, "melding" => "Ongeldige inloggegevens."]);
    }
} catch (PDOException $e) {
    echo json_encode(["succes" => false, "melding" => "Databasefout: " . $e->getMessage()]);
}
