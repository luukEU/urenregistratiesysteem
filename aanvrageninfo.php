<?php
require 'config.php';

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
      margin: 0;
      padding: 0;
    }
    .navbar {
      width: 100%;
      background: #222;
      padding: 15px;
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
      text-align: center;
    }
    h2 {
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
    /* Knop gecentreerd */
    .btn-add {
      display: flex;
      justify-content: center;
      margin: 20px 0;
    }
    .btn-add a button {
      background: #28a745;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn-add a button:hover {
      background: #218838;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <a href="index.html">⬅ Terug naar Home</a>
  </div>

  <div class="container">
    <h2>Aanvragen Overzicht</h2>

    <!-- Toevoegen knop in het midden -->
    <div class="btn-add">
      <a href="aanvragen.html"><button>Toevoegen</button></a>
    </div>

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
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='5'>Geen aanvragen gevonden</td></tr>";
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
