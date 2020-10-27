<?php 
session_start();

//variable for navigator to know what tittle to use
$_SESSION['mainpage'] = false;
$_SESSION['quizpage'] = true;
$_SESSION['flagpage'] = false;

//arrays for radio buttons and combobox
$parts = array('Europe', 'Asia', 'Africa');       
$questions = array('Capital', 'Flag', 'Animal', 'Flower');


if (!isset($_SESSION['amount'])) $_SESSION['amount'] = 0; // counts amount of questions
if (!isset($_SESSION['rnd'])) $_SESSION['rnd'] = 0; //randomly chosen number for question
if (!isset($_SESSION['index'])) $_SESSION['index'] = 1; // shows what question is now on
if (!isset($_SESSION['score'])) $_SESSION['score'] = 0; // counts points
if (!isset($_SESSION['part'])) $_SESSION['part'] = ''; // shows part of the world
if (!isset($_SESSION['capital'])) $_SESSION['capital'] = ''; //keeps correct answer for question "capital"
if (!isset($_SESSION['image'])) $_SESSION['image'] = '';  //keeps corrent picture for ohter 3 questions
if (!isset($_SESSION['question'])) $_SESSION['question'] = ''; //keeps what question is going now
if (!isset($_SESSION['numbers'])) $_SESSION['numbers'] = array(); //array to not ask twice same question
if (!isset($_SESSION['prosess'])) $_SESSION['prosess'] = false; //shows if answering question is in prosess
if ($_SESSION['uid'] == '') $_SESSION['uid'] = 'guest';  //makes id value to be "guest"
if (!isset($_SESSION['percent'])) $_SESSION['percent'] = 0;

// variables to change classes of div elements
if (!isset($_SESSION['start'])) if ($_SESSION['app2_islogged'] == false) $_SESSION['start'] = 1; else $_SESSION['start'] = 0;  //heps to change class for start text
if (!isset($_SESSION['main'])) $_SESSION['main'] = 0;  //heps to change class for questions
if (!isset($_SESSION['end'])) $_SESSION['end'] = 0;  //heps to change class for start text
if (!isset($_SESSION['error'])) $_SESSION['error'] = 0; //shows mistake if data isn't chosen

$string = file_GET_contents("json/countries.json");
$json = json_decode($string, true);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Quiz</title>
    <link href="css/quiz.css" rel="stylesheet" type="text/css" />
    <meta charset='UTF-8'>
  </head>
  <body>
      <?php include('php/navbar.php'); ?>
      <form action = 'php/questions.php' method='post'>
          <div id="page">
            
            <!-- shows who is user -->
            <div id="left">
                <?php
                    echo "<p> You are <b>" . $_SESSION['uid'] . "</b></p>\n";
                ?>
            </div>
            <div id="right">
                
                <!-- shows mistake if person didn't login -->
                <div id="mistake" style="display:<?php if ($_SESSION['app2_islogged'] == true) echo 'none'; else echo 'block';?>">
                    <p> You have to login to be able to play!</p>
                </div>

                <!-- shows possilbe questions -->
                <div id="question" style="display:<?php if ($_SESSION['start'] == 1) echo 'none'; else echo 'block';?>">
                  <p style="color:<?php if ($_SESSION['error'] == 1) echo 'red';?>">Please choose part of World:</p>
                      <?php 
                        //choosing part of world
                        echo "<table>\n";
                        foreach($parts as $nimi)
                        {
                            echo "<tr><td><input type='radio' name='part' value='$nimi'> $nimi <br></td></tr>\n";
                        }
                        echo "</table>\n";
                      ?>
                    <div id="span">
                      <span>Also choose question:</span> 
                      <?php
                        //choosing question
                        echo "<select name='question' metod='get'>\n";
                        foreach($questions as $nimi)
                        {
                            echo "<option value=$nimi> $nimi </option>\n";
                        }
                        echo "</select><br>";
                      ?> 
                  </div>
                  <div class="button"><input class="btn" type='submit' value='GO!' name='action'></div>
                </div>

                <!-- shows question itself -->
                <div style="display:<?php if ($_SESSION['main'] == 0) echo 'none'; else echo 'block';?>">
                <?php
                    switch ($_SESSION['question']) {
                        case 'Capital':
                            capital($json);
                            break;
                        case 'Flag':
                            flag($json);
                            break;
                        case 'Animal':
                            $option = 'animal';
                            $folder = 'pictures/animals/';
                            aniflo($json, $option, $folder);
                            break;
                        case 'Flower':
                            $option = 'flower';
                            $folder = 'pictures/flowers/';
                            aniflo($json, $option, $folder);
                            break;
                    }
                    echo "<img id='pr' src='php/prosenttia_tehty.php?percent={$_SESSION['percent']}'>";
                ?>
                <br>
                <div id="buttons">
                    <input class="btn" id="exit" type='submit' value='Exit' name='exit'>
                    <input class="btn" id="next" type='submit' value='Next' name='next'>
                </div>
              </div>

              <!-- showes result of answering question -->
              <div style="display:<?php if ($_SESSION['end'] == 0) echo 'none'; else echo 'block';?>">
                <?php
                  echo "<p> You have got: " . $_SESSION['score'] . "/" . $_SESSION['amount'] * 5 . " points. </p>\n";
                ?>
                  <div class="button"><input class="btn" type='submit' value='Exit' name='exit'></div>
              </div>
            </div>
        </div> 
      </form>
  </body>
</html>

<?php


//makes question "capital"
function capital($json) {
    $cities = Array();
    foreach ($json[$_SESSION['part']] as $country) {
        if ($_SESSION['rnd'] == $country['index']) {
            echo "<p>What is the capital of " . $country['name'] . "?</p>\n";
            $_SESSION['capital'] = $country['capital']; //gets correct answer
            $i = 0;
            //gets cities of country from json
           foreach ($country['cities'] as $city) {
               $cities[$i] = $city;
               $i++;
           }
        }
    }
    //mixes cities and prints them
    shuffle($cities);
    echo "<div id='capital'><table>\n";
    foreach ($cities as $c) echo "<tr><td><input type='radio' name='city' value='$c'> $c</td></tr>\n";
    echo "</table></div>\n";
}


//makes question "flag"
function flag($json) {
    $pictures = Array();
    foreach($json[$_SESSION['part']] as $country) {
        if ($country['index'] == $_SESSION['rnd']) {
            $_SESSION['image'] = $country['image']; //gets correct answer
            echo "<p> What is the flag of " . $country['name'] . " ?</p><br>\n";
        }
        else array_push($pictures, $country['image']); //makes array of pictures except correct one
    }
    shuffle($pictures);
    //makes new array with correct answer and 2 random pictures from previous array
    $result = Array();
    array_push($result, $_SESSION['image']);
    for ($i=0;$i<2;$i++) array_push($result, $pictures[$i]);
    //again shuffles result array and prints it
    shuffle($result);
    foreach($result as $r) {
        $src = "pictures/flags/" . $r;
        echo "<input type='radio' name='flag' value='$r'> <img class='img' id='flag' src=$src />\n";
    }
}


//makes question "animal" or "flower"
function aniflo($json, $option, $folder) {
    $pictures = Array();
    $names = Array();
    foreach($json[$_SESSION['part']] as $country) {
        if ($country['index'] == $_SESSION['rnd']) {
            $_SESSION['image'] = $country['image']; //gets correct picture
            $answer = $country[$option]; //gets correct name
            echo "<p> What is the " . $option . " of " . $country['name'] . " ?</p><br>\n";
        }
        else {
            //makes 2 array: one with name and picture and other with only name
            $pictures[$country[$option]] = $country['image'];
            array_push($names, $country[$option]);
        }
    }
    //mixes array with only names
    shuffle($names);
    //makes 2 new array again one for only names and one for names and pictures
    $result = Array();
    $result2 = Array();
    //puts there correct answer
    $result[$answer] = $_SESSION['image'];
    array_push($result2, $answer);
    //gets there 2 random options
    foreach($pictures as $a => $r) {
        for($i=0;$i<2;$i++) {
            if ($names[$i] == $a) {
                $result[$a] = $r;
                array_push($result2,$a);
            }
        }
    }
    //again mixes array of names and prints acording to it array of names and pictures
    shuffle($result2);
    echo "<table><tr>\n";
    for($i=0;$i<3;$i++) {
        foreach($result as $a => $r) {
            if ($result2[$i] == $a) {
                echo "<td><input type='radio' name='flag' value='$r'> $a</td>\n";
            }
        }
    }
    echo "</tr><tr>";
    for($i=0;$i<3;$i++) {
        foreach($result as $a => $r) {
            if ($result2[$i] == $a) {
                $src = $folder . $r;
                echo "<td><img class='img' src=$src /></td>\n";
            }
        }
    }
    echo "</tr></table>\n";
}

?>