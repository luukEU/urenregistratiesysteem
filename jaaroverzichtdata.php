<?php

$servername = "localhost"; // Of het IP-adres van je database
$username = "root"; // Je database gebruikersnaam
$password = ""; // Je database wachtwoord
$dbname = "klanten_db"; // De naam van je database
$charset = 'utf8';

// Query data met klant- en opdrachtinformatie
$sql = "
  SELECT 
    werkzaamheden.datum,
    werkzaamheden.uren,
    werkzaamheden.uren * opdrachten.tarief AS opbrengst,
    werkzaamheden.naam AS opdracht,
    klanten.naam AS klant
  FROM opdrachten
  JOIN klanten ON opdrachten.klant_id = klanten.id
";

$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
