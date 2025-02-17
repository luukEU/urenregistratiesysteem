<?php
require 'config.php';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Formulierwaarden ophalen en sanitizen
        $naam = trim($_POST["naam"]);
        $tussenvoegsel = trim($_POST["tussenvoegsel"]);
        $bedrijf = trim($_POST["bedrijf"]);
        $functie = trim($_POST["functie"]);
        $telefoon = trim($_POST["telefoon"]);
        $adres = trim($_POST["adres"]);
        $email = trim($_POST["email"]);
        $bericht = trim($_POST["bericht"]);

        // SQL-query voorbereiden en uitvoeren
        $sql = "INSERT INTO klanten (naam, tussenvoegsel, bedrijf, functie, telefoon, adres, email, bericht) 
                VALUES (:naam, :tussenvoegsel, :bedrijf, :functie, :telefoon, :adres, :email, :bericht)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":naam" => $naam,
            ":tussenvoegsel" => $tussenvoegsel,
            ":bedrijf" => $bedrijf,
            ":functie" => $functie,
            ":telefoon" => $telefoon,
            ":adres" => $adres,
            ":email" => $email,
            ":bericht" => $bericht
        ]);

        // Bevestiging en terugsturen naar formulier
        echo "<script>alert('Bedankt voor je inzending!'); window.location.href = 'index.html';</script>";
    }
} catch (PDOException $e) {
    die("Fout bij verbinden met database: " . $e->getMessage());
}
?>
