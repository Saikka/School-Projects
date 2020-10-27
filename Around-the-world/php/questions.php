<?php
session_start();

require_once('/home/K8760/php/db-harkka.php');
$string = file_GET_contents("../json/countries.json");
$json = json_decode($string, true);
$id = $_SESSION['uid'];

if (isset($_POST['action'])) {
    $_SESSION['question'] = $_POST['question'];
    $_SESSION['prosess'] = true;
    if (isset($_POST['part'])) {
        $_SESSION['part'] = $_POST['part'];
        foreach ($json[$_SESSION['part']] as $value) {
            $_SESSION['amount']++;
        }
        $_SESSION['start'] = 1;
        $_SESSION['main'] = 1;
        $_SESSION['rnd'] = mt_rand(0,$_SESSION['amount']-1);
        array_push($_SESSION['numbers'], $_SESSION['rnd']);
    }
    else $_SESSION['error'] = 1;
}

if (isset($_POST['next'])) {
    if ($_SESSION['question'] == 'Capital') {
        if ($_SESSION['capital'] == $_POST['city']) $_SESSION['score'] += 5;
    }
    else if ($_SESSION['image'] == $_POST['flag']) $_SESSION['score'] += 5;
    $rnd = rand(0,$_SESSION['amount']-1);
    if ($_SESSION['index'] < $_SESSION['amount']) {
        $i = 0;
        while($i < sizeof($_SESSION['numbers'])) {
            if ($rnd == $_SESSION['numbers'][$i]) {
                $rnd = mt_rand(0,$_SESSION['amount']-1);
                $i = 0;
            }
            else $i++;
        }
        $_SESSION['rnd'] = $rnd;
        array_push($_SESSION['numbers'], $rnd);
        $_SESSION['percent'] = $_SESSION['index'] * 100 / $_SESSION['amount'];
        $_SESSION['index']++;
    }
    else {
        $_SESSION['end'] = 1;
        $_SESSION['main'] = 0;
        $stmt = selectPoints($db, $id);
        if (compare($stmt) == true) $stmt = addtoDB($db, $id);
    }
}

if (isset($_POST['exit'])) {
    unset($_SESSION['start']);
    $_SESSION['prosess'] = false;
    $_SESSION['main'] = 0; 
    $_SESSION['end'] = 0;  
    $_SESSION['error'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['amount'] = 0;
    $_SESSION['index'] = 1;
    $_SESSION['percent'] = 0;
    $_SESSION['numbers'] = array();
}

if (isset($_POST['clear'])) {
    session_destroy();
}

function addtoDB($db, $id) {
   $sql = <<<SQLEND
   UPDATE points INNER JOIN part SET $_SESSION[question]=$_SESSION[score] WHERE points.part_id = part.id AND user_id=:id AND part.name='$_SESSION[part]'
SQLEND;

   $stmt = $db->prepare($sql);
   $stmt->bindValue(':id', "$id", PDO::PARAM_STR);
   $stmt->execute();
   return $stmt;    
}

function selectPoints($db, $id) {
   $sql = <<<SQLEND
   SELECT $_SESSION[question] FROM points 
   INNER JOIN part WHERE points.part_id = part.id AND points.user_id=:id AND part.name='$_SESSION[part]'
SQLEND;
    
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':id', "$id", PDO::PARAM_STR);
   $stmt->execute();
   return $stmt;    
}

function compare($stmt) {
   $row = $stmt->fetch(PDO::FETCH_ASSOC);  
   if ($row[$_SESSION['question']] < $_SESSION['score']) return true; else return false;
}

header("Location: https://" . $_SERVER['HTTP_HOST']
                            . dirname($_SERVER['PHP_SELF']) . '/'
                            . "../quiz.php");




