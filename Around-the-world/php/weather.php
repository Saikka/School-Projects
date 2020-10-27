<?php

$q = $_REQUEST["q"];


$polku = "/data/2.5/weather?APPID=95983d94fe41bc5ebaa8e558b25e915f&q=".$q."&units=metric&cnt=7&lang=en";

//info sivusta////////////////////////////////
$kohde_kone = "api.openweathermap.org";
$kohde_portti = 80;
$kohde_polku = $polku;
$pyyntometodi = "GET";
$pyyntorivi = "$pyyntometodi $kohde_polku HTTP/1.1\r\n";
$otsakkeet  = "Host: $kohde_kone\r\n";
$otsakkeet .= "Connection: Close\r\n\r\n";
$http_vastaus = '';
$html_osuus   = FALSE;
/////////////////////////////////////////////

$fp = fsockopen($kohde_kone, $kohde_portti, $errno, $errstr, 30);
if (!$fp) {
   echo "$errstr ($errno)<br />\n";
} else {
   //Lähetetään HTTP-pyyntö ja otsakkeet
   fputs($fp, $pyyntorivi);
   fputs($fp, $otsakkeet);

   // Luetaan ja tulostetaan HTTP-vastaus
    while (!feof($fp)) {
        $http_vastaus .= fgets($fp, 2056);
    }

    fclose($fp);
}

// HTTP-vastaus riveittäin taulukkoon 
$http_vastaus = str_replace("\r", "", $http_vastaus);
$rivit = explode("\n", $http_vastaus);

// Otetaan HTTP-vastauksesta vain data-osan JSON-osuus, joka
// on yhdellä {-merkillä alkavalla rivillä
 
$json = "";
foreach ($rivit as $arvo)
{
    // Ensimmäinen tyhjä rivi erottaa HTTP-otsakkeet data-
    // osasta eli HTML-osuudesta
    if ($arvo == "")
        $html_osuus = TRUE;
  
    if ($html_osuus AND (substr($arvo,0, 1) == "{") )
        $json .= $arvo;
}
// JSON_datan jäsentäminen data-taulukkoon
$data=json_decode($json, true);
$fail = false;
foreach($data as $d)
    if ($d == "city not found") {
        $fail = true;
        break;
    } 
if ($fail == true) echo "fail"; else echo $data['main']['temp'] . " C";


?>