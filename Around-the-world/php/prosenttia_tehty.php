<?php

/**
 * prosenttia_tehty.php
 *
 * Original: Public Domain by Mikael Gueck <gumi@iki.fi>
 * 2002-02-02
 *
 * ChangeLog
 * 2004-04-01 Ari Rantala <Ari.Rantala@co.jyu.fi>
 * -> Marginaalisia muutoksia, kommentointi suomeksi
 *
 * PHP-skripti, jonka sisään on upotettu BASE64-koodattu
 * kuva, jota voidaan käyttää esim. "prosenttia tehty"-
 * palkin pohjana. Näin vältytään huolehtimasta
 * erillisestä kuvasta ja viittauksista siihen
 *
**/

/* ------------------------------------------------------------------------ */
/* BASE64-koodattu kuva (Mikael Gueck) */

$pic_base64 = <<<EOP
iVBORw0KGgoAAAANSUhEUgAAAToAAAAgBAMAAABwVqkmAAAABGdBTUEAALGP
C/xhBQAAAC1QTFRFAAAA////wMDAcXFxS0tLQEBAVVVVAAAAqqqqjo6Ox8fH
HR0d4+PjOTk5cnJyhp3VtQAAAAF0Uk5TAEDm2GYAAAABYktHRACIBR1IAAAA
CXBIWXMAAAsSAAALEgHS3X78AAAAB3RJTUUH0gIDAAcmZhv4MAAAAUhJREFU
eAFjEKQIpKVNxNQvhUUMUxUxIgzEKMKtpqJjJ6pkBpArkYgqRj6PQtcVCrYJ
rlgoeEKwQ1CqS7CnQ+oe0HEdiVI9QDZIhEJAsevyJK/tFM84nbZxbvbE6uyX
ewUFc9MTc7Mbq7MfAkUG1nXl5XekBU+LH3wp+GajzMYaicQMQamLklkbpUBs
oMjAuq5QULA7u1xcMENQYtv2wkKQ6yQSJTISBYHsDKDIgLtureApccGXgjMu
yiwEuw4adoUSWUCRAXed2LUd4oLAdAdMa0DXpcHSHZANFBlY14GsX7FQQhCS
ZxtlFp4A5tkeQWCeBbIHPM9SGDaEtFNYohAynkL5Qe46ZZfBC4wYTAev41yC
GVwoTBq01O4y6jqyg3c07MgOOsHRsBsNO/JDgHydo+luNOzIDwHydY6mu+Eb
doO79TmoW+4AInIY611RHVwAAAAASUVORK5CYII=
====
EOP;

/* ------------------------------------------------------------------------ */
/* Puretaan koodaus -> saadaan kuva, josta luodaan "kuva-olio"*/
$pic = base64_decode($pic_base64);
$i = imagecreatefromstring($pic);

/* Puretun kuvan dimensiot selville */
$w = imagesx($i);
$h = imagesy($i);


/* Kopioidaan uuteen kuvaan (alkuperäisessä pieni värimäärä) */
$j = imagecreate($w, $h);
imagecopy($j, $i, 0, 0, 0, 0, $w, $h);
imagedestroy($i);

/* ------------------------------------------------------------------------ */
$percent = $_GET["percent"];

$c_blue  = imagecolorallocate($j, 14, 21, 133);
$c_yellow    = imagecolorallocate($j, 63, 252, 239);

fill_percent($j, $percent, $c_blue, $c_yellow);

/* ------------------------------------------------------------------------ */
header("Content-type: image/png");
imagepng($j);
imagedestroy($j);
exit();

/* ------------------------------------------------------------------------ */
/*
 *  Funktio täyttää puretusta kuvasta $percent prosenttia $c_blue-värillä
 *  ja loput punaisella
 */

function fill_percent($image, $percent, $c_blue, $c_yellow) {

    /* Täytettävä suorakulmio. Huomaa: Mustat reunukset jää täyttämättä */
    $sx = 2; // aloituspiste X-suunnassa
    $sy = 14; //aloituspiste Y-suunnassa
    $ex = 309; // lopetuspiste X-suunnassa
    $ey = 15; // lopetuspiste Y-suunnassa

    /* Prosenttilukema pakotetaan tarvittaessa oikelle välille */
    $percent = (integer) $percent;
    if($percent < 0)
        $percent = 0;
    if($percent > 100)
        $percent = 100;

    /* Vihreän alueen täyttö */
    if($percent > 0) {
        $width = ($percent / 100 ) * $ex ; // Täytettävä leveys pikseleinä
        imagefilledrectangle($image, $sx, $sy,
            $sx + $width, $sy + $ey, $c_blue);// $ey = koko korkeus täytetään 
    } else {
        $width = 0;
    }

    /* Loput täytetään punaisella */
    if($percent < 100) {
        imagefilledrectangle($image, $sx + $width, $sy,
            $sx + $ex, $sy + $ey, $c_yellow);
    }

}

?>