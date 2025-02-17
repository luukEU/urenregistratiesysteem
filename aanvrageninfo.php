<?php
// Database verbinding
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "klanten_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer de verbinding
if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}


// Haal aanvragen op
$sql = "SELECT * FROM aanvragen";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aanvragen Overzicht</title>
  <style>
    body {
      background: url('images/Simple chill wallpaper 1920 x 1080 - Wallpaper.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      margin: 0;
      padding: 0;
    }
    .navbar {
      width: 100%;
      background: #222;
      padding: 15px;
      text-align: left;
      position: fixed;
      top: 0;
      left: 0;
    }
    .navbar a {
      color: white;
      text-decoration: none;
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 5px;
    }
    .navbar a:hover {
      background: #444;
    }
    .container {
      background: rgba(34, 34, 34, 0.9);
      color: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      width: 80%;
      max-width: 800px;
      margin-top: 100px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #333;
    }
    tr:hover {
      background-color: #444;
    }
    /* Zorgt ervoor dat de knoppen in de Acties-cel naast elkaar blijven */
    .actions-cell {
      display: flex;
      align-items: center;
      gap: 10px;
      white-space: nowrap;
    }
    /* Kleine knoppen: zowel voor Toevoegen als Verwijderen */
    .btn-add-small, .btn-delete {
      padding: 6px 10px;
      border: none;
      cursor: pointer;
      border-radius: 6px;
      font-size: 12px;
      transition: 0.3s ease-in-out;
    }
    .btn-add-small {
      background: #28a745;
      color: white;
    }
    .btn-add-small:hover {
      background: #218838;
    }
    .btn-delete {
      background: #d9534f;
      color: white;
    }
    .btn-delete:hover {
      background: #c9302c;
    }
    /* Zorgt ervoor dat de Toevoegen-knop gecentreerd wordt boven de tabel */
    .add-btn-container {
      display: flex;
      justify-content: center;
      margin-bottom: 20px;
    }
    .add-btn {
  float: right;
  padding: 10px 20px;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}



  </style>
</head>
<body>
  <div class="navbar">
    <a href="index.html">⬅ Terug naar Home</a>
    
    <style>
    button {
        background-color: #007bff; /* Blauwe achtergrond */
        color: white; /* Witte tekst */
        padding: 10px 20px; /* Ruimte rondom tekst */
        font-size: 16px; /* Grotere tekst */
        border: none; /* Geen rand */
        border-radius: 5px; /* Afgeronde hoeken */
        cursor: pointer; /* Hand-icoon bij hover */
    }

    button:hover {
        background-color: #0056b3; /* Donkerdere kleur bij hover */
    }

    @media print {
        button { 
            display: none; /* Verberg knop bij printen */
        }
    }
</style> 

<button onclick="window.print()">PDF omzetten</button>

  </div>
 

  <!-- Toevoegen knop boven de tabel -->
  <div class="add-btn-container">
   
  </div>
  
  <div class="container">
  <h2>
  Aanvragen Overzicht 
  <span class="add-btn">
   <center>
  <a href="aanvragen.html"><button class="btn-add-small">Toevoegen</button></a>
  </center>
  </span>
</h2>

    
    <table>
      <thead>
        <tr>
         
          <th>Klantnaam</th>
          <th>Titel</th>
          <th>Omschrijving</th>
          <th>Aanvraagdatum</th>
          <th>Kennis</th>
          
        </tr>
      </thead>
      <tbody>
        <?php
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                      
                          <td>" . htmlspecialchars($row['klantnaam']) . "</td>
                          <td>" . htmlspecialchars($row['titel']) . "</td>
                          <td>" . htmlspecialchars($row['omschrijving']) . "</td>
                          <td>" . htmlspecialchars($row['aanvraagdatum']) . "</td>
                          <td>" . htmlspecialchars($row['kennis']) . "</td> 
                             
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='7'>Geen aanvragen gevonden</td></tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>

<?php
$conn->close();
?>