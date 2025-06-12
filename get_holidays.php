<?php
function getPublicHolidays($year = null) {
    $year = $year ?? date('Y');
    $countryCode = 'NL';
    $apiUrl = "https://date.nager.at/api/v3/PublicHolidays/$year/$countryCode";

    $json = @file_get_contents($apiUrl);

    if ($json === false) {
        return ['error' => 'Kon de feestdagen niet ophalen.'];
    }

    $holidays = json_decode($json, true);

    return $holidays;
}
?>
