<?php
$pdo = new PDO('mysql:host=localhost;dbname=uren_db', 'root', '');

// Query data met klant- en opdrachtinformatie
$sql = "
  SELECT 
    opdrachten.datum,
    opdrachten.uren,
    opdrachten.uren * opdrachten.tarief AS opbrengst,
    opdrachten.naam AS opdracht,
    klanten.naam AS klant
  FROM opdrachten
  JOIN klanten ON opdrachten.klant_id = klanten.id
";

$stmt = $pdo->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
