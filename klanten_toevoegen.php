<?php
// Verbinding maken met de database
require 'config.php';

// Klanten ophalen voor dropdown
$klanten = $conn->query("SELECT id, naam FROM klanten");
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klantenformulier</title>
    <style>
        body {
            background: url('images/Simple chill wallpaper 1920 x 1080 - Wallpaper.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .navbar {
            width: 100%;
            background: #222;
            padding: 15px;
            text-align: left;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        .navbar img {
            height: 20px;
            margin-right: 10px;
        }
        .container {
            background: rgba(34, 34, 34, 0.9);
            color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 5px 1px rgba(0, 0, 0, 0.3);
            width: 90%;
            max-width: 400px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-sizing: border-box;
        }
        h2 {
            text-align: center;
            color: white;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: white;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.3s ease-in-out;
            background: #333;
            color: white;
        }
        input:focus, select:focus {
            outline: none;
            background: #444;
        }
        button {
            background: #28a745;
            color: white;
            padding: 12px;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
            transition: 0.3s ease-in-out;
        }
        button:hover {
            background: #218838;
        }

        @media (max-width: 600px) {
            .navbar {
                text-align: center;
                padding: 10px 15px;
            }
            .navbar a {
                font-size: 14px;
                padding: 8px 16px;
            }
            .container {
                width: 95%;
                padding: 15px;
                max-width: none;
            }
            h2 {
                font-size: 20px;
            }
            label {
                font-size: 14px;
            }
            input, select {
                font-size: 14px;
            }
            button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="hoofdpagina.php">⬅ Terug naar Home</a>
        <a href="klanteninfo.php">
            <img src="images/devopslogo.png" alt="Home" class="home-logo">
        </a>
    </div>

    <div class="container">
        <h2>Klanten formulier</h2>
        <form action="medewerkersinfo.php" method="POST">
            <input type="hidden" name="form_type" value="medewerkers">

            
<div class="radio-wrapper">
    <div class="radio-row">
        <label for="bestaande">Bestaande klant kiezen:</label>
        <input type="radio" id="bestaande" name="klantkeuze" value="bestaande" checked onchange="toggleKlantInput()">
    </div>
    <div class="radio-row">
        <label for="nieuwe">Nieuwe klant invoeren:</label>
        <input type="radio" id="nieuwe" name="klantkeuze" value="nieuwe" onchange="toggleKlantInput()">
    </div>
</div>


<div id="bestaandeKlantDiv">
    <label for="klant_id">Selecteer klant:</label>
    <select id="klant_id" name="klant_id">
        <option value="">-- Selecteer een klant --</option>
        <?php while($klant = $klanten->fetch_assoc()): ?>
            <option value="<?= $klant['id'] ?>"><?= htmlspecialchars($klant['naam']) ?></option>
        <?php endwhile; ?>
    </select>
</div>

<div id="nieuweKlantDiv" style="display: none;">
    <label for="nieuwe_klant_naam">Nieuwe klantnaam:</label>
    <input type="text" id="nieuwe_klant_naam" name="nieuwe_klant_naam" placeholder="Voer nieuwe klantnaam in">
</div>

<script>
function toggleKlantInput() {
    const isBestaande = document.getElementById('bestaande').checked;
    document.getElementById('bestaandeKlantDiv').style.display = isBestaande ? 'block' : 'none';
    document.getElementById('nieuweKlantDiv').style.display = isBestaande ? 'none' : 'block';

    // Vereist-attributen dynamisch aanpassen
    document.getElementById('klant_id').required = isBestaande;
    document.getElementById('nieuwe_klant_naam').required = !isBestaande;
}
</script>


            <label for="tussenvoegsel">Tussenvoegsel:</label>
            <input type="text" id="tussenvoegsel" name="tussenvoegsel" placeholder="Bijv. van, de, der">

            <label for="geboortedatum">Geboortedatum:</label>
            <input type="date" id="geboortedatum" name="geboortedatum" required>

            <label for="functie">Functie:</label>
            <input type="text" id="functie" name="functie" placeholder="Functie binnen het bedrijf" required>

            <label for="werkmail">Werkmail:</label>
            <input type="email" id="werkmail" name="werkmail" placeholder="Werkmail" required>

            <label for="kantoorruimte">Kantoorruimte:</label>
            <input type="text" id="kantoorruimte" name="kantoorruimte" placeholder="Bijv. Kamer 202" required>

            <button type="submit">Verzenden</button>
        </form>

    </div>
</body>
</html>
<?php $conn->close(); ?>
