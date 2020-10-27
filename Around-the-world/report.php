<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Report</title>
    <link href="css/report.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
      <a href="main.php">Back</a>
      <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
      <div id="page">
        <div id="johdanto">
            <h1> Johdanto </h1>
            <h4>
                Harjoitustyö tehtiin parityönä. Päätimme yhdistää web-ohjelmoinnin ja web-palveluohjelmoinnin kurssien harjoitustyöt. Käytimme harjoitustyössä php, js, json, react ja mySQL-tietokantaa. Harjoitustyö on verkkosivu muodossa, jossa on tietoja eri maanosista ja näiden maista. sivuilla on myös pelejä niihin liittyen. Käyttäjät ja pelien pistemäärät tallentuvat tietokantaan. Kirjautuneella henkilöllä on laajemmat oikeudet sivujen tutkimiseen. Tiedot maista ovat json:ssa tekstinä ja kuvina, josta tiedot haetaan. Sovelluksessa on pelimäisiä kysymyksiä, joista saa pisteitä. Pisteet tallentuvat tietokantaan. Sovelluksesta löytyy myös drag and drop-peli johon kuvat haetaan satunnaisesti json:sta.
            </h4>
        </div>
        <div id="suunnittelu">
            <h1> Suunnittelu </h1>
            <h4>
                Sivut suunniteltiin suurpiirteisesti, eli listattiin vaatimusten ja kurssilla tehtyjen asioiden perusteella mitä sivuille täytyy tulla. Näiden pohjalta pystyimme hahmottelemaan graafisennäkymän fluiduilla. Aluksi ajatuksena oli tehdä tiedot ja kysy-mykset Euroopan maista, mutta päädyimme tekemään isomman ja laajemman, tekemällä Eri maanosita ja niiden kaupungeista. Alkuperäisessä suunnitelmassa ei ollut vielä tietoa kysymysten sisällöistä tai kysymysmuodoista. Suunnitelmaamme kuului myös SQL-taulu, jossa oli ainoastaan henkilön kirjautumiseen liittyvät tiedot.
            </h4>
            <h3> Miten sivusto näkyi suunnittelussa: </h3>
            <img src="pictures/report/s1.jpg" />
            <img src="pictures/report/s2.jpg" />
            <img src="pictures/report/s3.jpg" />
            <img src="pictures/report/s4.jpg" />
            <img src="pictures/report/s5.jpg" />
            <img src="pictures/report/s6.jpg" />
            <h3> Miten tietokanta näkyi suunnittelussa: </h3>
            <img src="pictures/report/s7.jpg" />
        </div>
        <div id="toteutus">
            <h1> Toteutus </h1>
            <h3> Eteneminen ja ongelmat </h3>
            <h4>
                Lähdimme tekemään harjoitustyötä ja matkalla tuli luontevia parannuksia ja ideoita harjoitustyöhömme. Ideoita kuten kysymysten aiheet. Kysymyksiä tuli maanosien maiden kaupungeista, lipuista,  eläimistä ja kukista. Kirjautumissivuissa ei hirveästi ongelmia ollut. Ainoastaan taulujen tiedot muuttuivat ja taulu piti luoda uudelleen. Drag and drop- peli päätettiin tehdä maiden lipuista. Kaksi suurinta ongelmaa pelissä oli saada kuvien satunnaisuus toimimaan ja canvaksen siirtäminen. Satunnaisuudessa oikean syntaksin löytäminen tuotti ongelmia, mikä lopulta ratkesi, kun tarpeeksi kauan yritti. Canvaksen ongelmana oli sen siirtäminen, oletuksena oli, että kun canvas siirtyy, niin samalla sen sisällä olevat elementit siirtyy. Lopulta selvisi, että canvaksen sisällä olevia elementtejä piti myös siirtää, kun canvasta siirretään. Reactissa oli eniten ongelmia, että sivulla piti painaa kaksi kertaa, ennen maanosa vaihtui, mutta opettaja autoi ja se oli fiksattu.
            </h4>
            <h3> Työnjako </h3>
            <h4>
                Tatu: teki php:lla kirjautumis- ja käyttäjänluontisivut. Javascriptillä Tatu teki lippupelin.
                Ekaterina: teki sivu "Info" reactilla ja sivu "Quiz" php:lla. Myös teki ulkoasu ja kuvijen haku.
                Raportti oli kirjoitettu molemmilla.
            </h4>
        </div>
        <div id="sql">
            <h1> MySQL </h1>
            <h4> 
                Työssä on käytetty tietokanta, jossa on kolme taulukkoa: "User", "Part" ja "Points". "Points" taulukko on tulos taulukko moni monien yhteydestä taulukoilla "User" ja "Part". "User" taulukkoon talentaan käyttäjän nimi ja salasana. "Part" taulukossa on maanosijen nimeja. 
            </h4>
            <img id="tk" src="pictures/report/eer.jpg" />
            <h4>
                Sivulla "Main" on käytössä taulukot "User" ja "Points".
            </h4>
            <h3> Kyselyt, jotka ovat käytetty sivulla "Main" </h3>
            <ul>
                <li>
                    <p> Login toiminta: </p>
                    <p class="sql"> SELECT id, password FROM user WHERE id = :uid </p>
                </li>
                <li>
                    <p> Tarkastaminen onko jo tietokannassa sama nimi, kuin yritetään luoda: </p>
                    <p class="sql"> SELECT * FROM user WHERE id LIKE :id </p>
                </li>
                <li>
                    <p> Lisätään käyttäjän nimi ja salasanan: </p>
                    <p class="sql"> INSERT INTO user VALUES('$_POST[nuid]','$_POST[npasswd1]') </p>
                </li>
                <li>
                    <p> Laitaan kaikki pisteet nollaksi, kun luodaan uuden käyttäjän: </p>
                    <p class="sql"> 
                        INSERT INTO points VALUES <br>
                        ('$_SESSION[uid]', 1, 0, 0, 0, 0),<br>
                        ('$_SESSION[uid]', 2, 0, 0, 0, 0),<br>
                        ('$_SESSION[uid]', 3, 0, 0, 0, 0) 
                    </p>
                </li>
                <li>
                    <p> Haetaan pisteet käyttäjälle: </p>
                    <p class="sql"> 
                        SELECT  part.name, capital, flag, animal, flower from points <br>
                        INNER JOIN part WHERE points.part_id = part.id AND points.user_id=:id 
                    </p>
                </li>
            </ul>
            <h4>
                Myös sivulla "Quiz" käytetään tietokannan taulukko "Points".  
            </h4>
            <h3> Kyselyt, jotka ovat käytetty sivulla "Quiz" </h3>
            <ul>
                <li>
                    <p> Tarkistetaan, että saattu pisteet ovat suurempi, kuin jo olevia taulukossa: </p>
                    <p class="sql"> 
                        SELECT $_SESSION[question] FROM points INNER JOIN part <br> 
                        WHERE points.part_id = part.id AND points.user_id=:id AND part.name='$_SESSION[part]' 
                    </p>
                </li>
                <li>
                    <p> Haetaan pisteet käyttäjälle: </p>
                    <p class="sql"> 
                        UPDATE points INNER JOIN part SET $_SESSION[question]=$_SESSION[score] <br>
                        WHERE points.part_id = part.id AND user_id=:id AND part.name='$_SESSION[part]' 
                    </p>
                </li>
            </ul>
        </div>
        <div id="js">
            <h1> Javascript </h1>
            <h4>
                Peli lähtee käyntiin, kun painaa buttonia play, se lataa init funktion, joka lataa kuvan satunnaisesti
                eri maanosien lipuista. Se tapahtuu ajaxin kautta json tiedostosta. Se laskee miten paljon maita yhdeessä on ja tekee kaski massivia: yksi kuvijen kanssa ja toinen numeroiden kanssa. Sitten tapahtuu sekoitus numeroisessa massivissa ja kuvat ovat kutsutu kuvjen massivista niin, että functio otaa järjestuksella numeroita numeiroiden massivilta ja käyttää numero indeksi kuvjien massivissa. Siitä se jatkaa onImagefunktioon, joka jakaa kuvan vaikeus asteen
                mukaan, joka on määritelty vakioksi const PUZZLE_DIFFICULTY:lla. Sitten luodaan canvas setCanvas
                funktiolla, joka on yhtäsuuri kuin kuva. Tämän jälkeen piirretään canvaksen ulkoreunat
                ja ohjelaatikko, joka kertoo käyttäjälle mitä hänen pitää tehdä. Seuraavaksi pelin toiminnan
                kannalta tärkeimpiin kohtiin eli mitä palalle tapahtuu, kun sitä liikutetaan. Palan liikkumista seuraa 
                onPuzzleClick, checkPieceClicked, updatePuzzle ja pieceDropped funktiot. Viimeiseksi paloja verrataan kuvaan
                ja tarkistetaan, onko palapeli oikein ja jos on peli palautetaan alkutilaan resetPuzzleAndCheckWin ja gameOver funktioilla.
            </h4>
        </div>
        <div id="react">
            <h1> React </h1>
            <h4>
                Reactilla on tehty sivu "Info". Se on dinaaminen sivu, koska data on ladattu json tiedostosta ajaxin kautta. Sivulla on kaksi classia: Navigator ja Countries. Navigator vain palautaa maanosijen nimejä. Kaikki muut tehty classissa Countries. Tässä classissa alkuperaiseti määritettu seuravia tietoja:
            </h4>
            <ul>
                <li><p>Countries - taulukko, jossa on valitun maanosan maita </p></li>
                <li><p>amount - palautaa maiden määrä </p></li>
                <li><p>part - palauttaa valittu maanosan</p></li>
                <li><p>ind - palauttaa näytelössä olevassa maan index</p></li>
                <li><p>loaded - palauttaa onko ajax ladattu tai ei</p></li>
                <li><p>weather - taulukko, johon haettu lämpön tiedot jokaiselle kaupunkille</p></li>
                <li><p>showWeather - taulukko, jossa on tiedot onko kaupungin lämpö nyt näytössä tai ei</p></li>
            </ul>
            <h3> Functiojen kuvailu </h3>
            <h4>
                <i>getCountry</i> functio lataa ajaxin kautta dataa valitusta maanosasta json tiedostolta. Tämä functio aina kutsuttu ensimmäisen renderin jälkeen, koska se on määritetty ComponentDidMountilla. Ensimmäisella kerralla se aina lataa Euroopan maita, koska Eurooppa on default value.
            </h4>
            <h4>
                <i>getPart</i> functio saa maanosan valintan. Tämä functio kutsuttu, jos navigatorin linkki oli painettu. Sitten se päivittää maanosan valintan ja kutsuu getCountry, että se lataa uudet tiedot jsonilta.
            </h4>
            <h4>
                <i>forward</i> ja <i>backward</i> functiot toimivat samanakoisesti, yksi nousee index ja toinen laskee sen. Ne käyttävät functiot indexValue ja indexValue2, joissa on määritetty tilanne, mihin asti index voi nousta ja mihin asti se voi laskea.
            </h4>
            <h4>
                <i>getWeather</i> lähettää php toimintaan kaupunkin nimi ja maan koodi ja palauttaa lämpön arvo jokaiselle kaupunkille. Se tapahtuu ajaxin kautta. Tämä functio kutsuttu kuvan klikkamisesta ja functio tarkistaa onko showWeather true tai false, jos false: se hakee sään tiedot ja jos true, se piiloo niitä.
            </h4>
            <h3> Rendorin kuvailu</h3>
            <h4>
                Sivulla on aina näytössä vain yksi maa, siksi ensikisi kutsutaan map taulukkoon countries ja etsitään maa, jolla on sama index kuin nyt menevä index. Sitten tulostaan classin Navigator ja nappija "Next" ja "Previous".
            </h4>
            <h4>
                Sitten toimitaan vain valitun maan kanssa. Annettaan body background-image maan lippu ja saadan kaupunkijen massivi. Sen jälkeen on maan tietojen tulostaminen: maan nimi, lippu, pääkaupunki ja taulukko isoista kaupunkeista, kansallaiset eläin ja kukka. 
            </h4>
            <h3> Ongelmat </h3>
            <h4> Oli tottakai monia pienija ongelmia, mutta oli kaksi isoja, jotka vivät paljon aikaa ratkaisumiseen.</h4>
            <ul>
                <li>
                    <p><b>Navigatorin toiminta:</b> jos painat linkki, ei mitää tapahtuu. Pitisi painaa kaksi kertaa, että maanosa vaihtoi</p>
                    <p>Miten oli koodissa: <br> getPart: function(p) { <br> this.setState({part: p }); <br> this.getCountry(); <br> }</p>
                    <p>Ratkaisu: getPart: function(p) { <br> this.setState({part: p}, function() {this.getCountry();}); <br> }</p>
                </li>
                <li>
                    <p><b>getWeather toiminta:</b> antonut virhen, jos painat kuvan.</p>
                    <p>getWeather oli mapin sisällä ja ei ollut oma bind</p>
                    <p>Ratkaisu: piti lisätä oma bind mapin jälkeen </p>
                </li>
            </ul>
        </div>
        <div id="php">
            <h1> PHP </h1>
            <h4>
                PHP toiminta on kaikeissa sivuissa tällä sivustolla. Navigator sivustolle on tehty erillisella php sivulla navbar, joka on sitten kutsuttu kaikeissa muissa suvuilla. Session toiminta on kaikeissa sivuilla ja navigatorin otsikko rippuu minkä session arvo on true, tämä arvo on palautettu sivulla, kuin se on avattu. Myös sivuissa on divin display rippuu session arvoista.
            </h4>
            <h3> Sivuston otsikkojen arvot:</h3>
            <ul>
                <li><p> $_SESSION['mainpage'] - on true, jos sivu on Main avattu </p></li>
                <li><p> $_SESSION['quizpage'] - on true, jos sivu on Quiz avattu </p></li>
                <li><p> $_SESSION['flagpage'] - on true, jos sivu on Flag avattu </p></li>
            </ul>
            <h3> Sivun Main functiot </h3>
            <ul>
                <li>
                    <p> Login toiminta:</p>
                    <p> Tarkastetaan onko tämä käyttäjän nimi tetokannassa ja onko salasana oikein ja sitten login onnistui</p>
                </li>
                <li>
                    <p> Sign in tominta:</p>
                    <p> Tarkestetaan onko tämä käyttäjän nimi jo käytetty, jos ei - tarkistetaan onko salasoja samoja - jos joo - tehdään uuden käyttäjän.</p>
                </li>
            </ul>
            <h3> Sivu Info</h3>
            <h4>
                Tässä sivussä on vahempi php toimintaa kuin muissa. On vain session ja jos $_SESSION['prosess'] on true, sivulla ei voi katsoa tiedot, koska se tarkoittaa, että quiz kyseily ei loppunut vielä ja siski ei mahdollista kurkata vastaukset.
            </h4>
            <h3> Sivun Quiz tominta </h3>
            <h4>
                Tässä sivussa on mahdollista vastaa kysymyksiin, jos olet kirjaitunut. Jos ei - sivu ei näytä mitää. Mahdollista valita maanosan ja kysymyksen: pääkaupunki, lippu, eläin tai kukka. Sivussa on eniten php toimintaa, siksi täällä on enitenkin session arovot. Formin toimintaa kutsuu sivun Questions, jossa tapahtuu sattumainen maan valintan ja pisteen lasketus. Sivulla kutsuttu json tiedosto, josta tapahtuu tietojen lukeminen. Myös sivulla on php kuva, joka näyttää edistymisen, se toimii kutsumalla php kuvan BASE64-koodattu.
            </h4>
            <h4> Sivulla on switch case rakenne, joka saa kysymyksen vallinnan ja kutsuu yksi kolmesta functio.</h4>
            <ul>
                <li>
                    <p>Functio "Capital"</p>
                    <p>
                        Functio menee maiden kautta ja etsii maan, jokalla on sama index, kuin ollut valitettu sivulla Questions. Pääkaupunkin arvo talennettu kuin oikea vastaus. Sitten functio tekee massivi maan kaupunkeista ja sekoittaa sen ja tulostaa näyttöön.
                    </p>
                </li>
                <li>
                    <p>Functio "Flag"</p>
                    <p>
                        Melkein sama toiminta, paisti, että kaikki maiden kuvat haettu massiviin, paisti oikeaa. Sitten massivi sekoitetaan ja tehdään uuden massivin, johon tulee oikea kuva ja kaksi kuvaa ensimmäisestä massivista. Taas sekitetaan ja tulostetaan.
                    </p>
                </li>
                <li>
                    <p>Functio "Aniflo"</p>
                    <p>
                        Se on functio kahdelle kysymyksille Animal ja Flower, koska niiden toiminta on samaa. Functio vain saa aluksi onko se eläin tai kukka, sekä kansion polkun. Toiminta on melkein sama, kuin luppun functiolla, mutta tässä on vaikeus, että massivi on kaksikertainen: eläimen tai kukan nimi ja kuva. Siksi tehdään kaksi massivia: yksi vain mimille, toinen nimille ja kuvalle. Taas ilman oikea vastusta. Sekoitetaan nimijen massivi ja tehdään kaksi uutta massivia, oikein vastauksen kanssa ja kahden toisten vaihtojen. Sitten sekoiteen nimijen massivi ja tulostetaan nimijen ja kuvijen massivi niin, että otetaan kaksikertaisesta massivista elementti, jokun nimi on sama kuin vain minijen massivin elementti.
                    </p>
                </li>
            </ul>
            <h3> Questions sivun toiminta </h3>
            <h4>
                Sivussa sattumaisesti valittaan numeron, se on index maalle, josta sitten kysytään. Se valitaa uuden index niin, että jokainen maa tulee vain yksi kertaa näkyville. Kuin kaikki maat menevat, se laskee pisteet ja talentaa niitä tietokantaan, jos saattu pisteet ovat isompi, kuin jo olevia tietokannassa.
            </h4>
            <h3> Weather sivun toiminta</h3>
            <h4>
                Sivulla saadan kaupunkin nimi ja maan koodi url:sta ja haetaan lämpön arvon. Jos kaupunki ei löyty, se palauttaa "fail", koska jotkut kaupunkit eivät ole sivulla ja emme tehneet spesiaalisen merkien tomintan, koska ei riitannut aikaa.
            </h4>
        </div>
        <div id="yhteenveto">
            <h1> Yhteenveto </h1>
            <h3> Lopullinen työ </h3>
            <h4>
                Työ saatiin valmiiksi kurssin aikana.<br>
                Ekaterina: PHP - noin 35 tunttia, Jacascript - noin 40 tunttia <br>
                Tatu: PHP - noin 20 tunttia, Jacascript - noin 26 tunttia
            </h4>
            <h4>
                Oma arviointi: <br>
                Ekaterina: PHP - 5, Javascript - 5 <br>
                Tatu: PHP - 3, Javascript - 3
            </h4>
            <h3>Kuvat valmistuneesta sivustosta</h3>
            <h4 style="text-align:center;">"Main" sivu:</h4>
            <img src="pictures/report/t1.jpg" />
            <img src="pictures/report/t2.jpg" />
            <img src="pictures/report/t3.jpg" />
            <h4 style="text-align:center;">"Info" sivu:</h4>
            <img src="pictures/report/t4.jpg" />
            <h4 style="text-align:center;">"Quiz" sivu:</h4>
            <img src="pictures/report/t5.jpg" />
            <img src="pictures/report/t6.jpg" />
            <img src="pictures/report/t7.jpg" />
            <img src="pictures/report/t8.jpg" />
            <img src="pictures/report/t9.jpg" />
            <img src="pictures/report/t10.jpg" />
            <h4 style="text-align:center;">"Flag" sivu:</h4>
            <img src="pictures/report/t11.jpg" />
            <h3> Loppu pohdinta: </h3>
            <h4>
                Työn olisi voinut suunnitella kattavammin ja paremmin. Dokumentointiakin olisi ollut hyvä tehdä samalla kun työtä tehtiin tai ainakin joitakin muistiinpanoja sitä varten. Työnjaossa suurempi vastuu/työmäärä tuli Ekaterinalle. Työstä opimme paljon käytyjä asioita php:lta ja reactilta, sekä myös css:n eli tyylien määrittelyjen toimintaa ja säännön alaisuuksia. Drag- ja drop- asia oli kokonais uutta meille, reactilla tuli parempi toiminta json:in tiedoston kanssa ja miten käyttää map functio, sekä miten tehdä bind useamille elementille ja miten saada functio toteuttu setStatella. PHP:lla tuli parempi osaaminen toimia tietokannan kanssa, oli tarkistettu, että jopa vaikea rakennettu kyselyjä voidaan käyttää. Myös oli parennettu osaamisen sessionilta, json:in käytöstä ja miten voi kutsua reactilla joku php functio.
            </h4>
        </div>
    </div>
    <script src="js/report.js"></script>
  </body>
</html>