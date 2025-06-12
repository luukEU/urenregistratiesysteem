<?php
include 'get_holidays.php';

$years = [date('Y'), date('Y') + 1, date('Y') + 2]; // dit jaar + 2 jaar vooruit
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Feestdagen Nederland</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 2rem;
        }
        .container {
            background: #fff;
            border-radius: 10px;
            padding: 2rem;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
        }
        h2 {
            margin-top: 2rem;
            border-bottom: 1px solid #ccc;
            padding-bottom: 0.5rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: 0.75rem;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .date {
            white-space: nowrap;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🇳🇱 Feestdagen Nederland</h1>

        <?php foreach ($years as $year): ?>
            <h2><?= $year ?></h2>
            <?php
                $holidays = getPublicHolidays($year);
                if (isset($holidays['error'])) {
                    echo "<p style='color:red'>{$holidays['error']}</p>";
                    continue;
                }
            ?>
            <table>
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Naam</th>
                        <th>Internationale naam</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($holidays as $holiday): ?>
                        <tr>
                            <td class="date"><?= date('d-m-Y', strtotime($holiday['date'])) ?></td>
                            <td><?= htmlspecialchars($holiday['localName']) ?></td>
                            <td><?= htmlspecialchars($holiday['name']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    </div>
</body>
</html>
