<?php
session_start();
require 'config.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Formulierwaarden ophalen en sanitizen
        $naam = trim($_POST["naam"]);
        $bedrijf = trim($_POST["bedrijf"]);
        $functie = trim($_POST["functie"]);
        $telefoon = trim($_POST["telefoon"]);
        $adres = trim($_POST["adres"]);
        $email = trim($_POST["email"]);
        $bericht = trim($_POST["bericht"]);
        $gebruiker_id = $_SESSION['gebruiker_id'];

        // SQL-query voorbereiden en uitvoeren (let op: nu mét gebruiker_id)
        $sql = "INSERT INTO klanten (naam, bedrijf, functie, telefoon, adres, email, bericht, gebruiker_id) 
                VALUES (:naam, :bedrijf, :functie, :telefoon, :adres, :email, :bericht, :gebruiker_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":naam" => $naam,
            ":bedrijf" => $bedrijf,
            ":functie" => $functie,
            ":telefoon" => $telefoon,
            ":adres" => $adres,
            ":email" => $email,
            ":bericht" => $bericht,
            ":gebruiker_id" => $gebruiker_id
        ]);

        // Bevestiging en terugsturen naar formulier
        echo "<script>alert('Bedankt voor je inzending!'); window.location.href = 'klanteninfo.php';</script>";
    }
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}
?>