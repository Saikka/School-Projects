<?php 

session_start();

require_once('/home/K8760/php/db-harkka.php');
$errmsg = '';

//variable for navigator to know what tittle to use
$_SESSION['mainpage'] = true;
$_SESSION['quizpage'] = false;
$_SESSION['flagpage'] = false;

//unsets variable start if answering question is over so in quiz it will show correct data
if (isset($_SESSION['prosess'])) if ($_SESSION['prosess'] == false) unset($_SESSION['start']); 

//variables for loging
if (!isset($_SESSION['app2_islogged'])) $_SESSION['app2_islogged'] = false;
if (!isset($_SESSION['uid'])) $_SESSION['uid']='';

//for div elements class
if (!isset($_SESSION['login'])) $_SESSION['login']=0;
if (!isset($_SESSION['in'])) $_SESSION['in']=0;
if (!isset($_SESSION['signin'])) $_SESSION['signin']=0;
if (!isset($_SESSION['points'])) $_SESSION['points']=0;

//loging system
if (isset($_POST['action']))
    if (isset($_POST['uid']) AND isset($_POST['passwd'])) {
    require_once('/home/K8760/php/db-harkka.php');
   $uid = $_POST['uid'];
   $passwd = $_POST['passwd'];

   $sql = "SELECT id, password
            FROM user
            WHERE id = :uid";

    $stmt = $db->prepare($sql);
    $stmt->execute(array($uid));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);  

    if ($stmt->rowCount() == 1 AND $passwd == $row['password']) {

        $_SESSION['app2_islogged'] = true;
        $_SESSION['uid'] = $_POST['uid'];
        $_SESSION['login']=1;
        $_SESSION['in']=1;
    } else {
        $errmsg = '<p style="color: red; text-align:center;">Wrong login or password!</p>';
    }
}

//logout system
if (isset($_POST['out'])) {
    $_SESSION['login']=0;
    $_SESSION['in']=0;
    $_SESSION['app2_islogged'] = false;
    $_SESSION['uid'] = '';
    $_SESSION['points']=0;
}

//signin system
if (isset($_POST['sign'])) {
    $_SESSION['login']=1;
    $_SESSION['signin']=1;
}

//canceling signin
if (isset($_POST['cancel'])) {
    $_SESSION['login']=0;
    $_SESSION['signin']=0;
}

//checking id and password and adding data to database
if (isset($_POST['accept'])) {
    if (($_POST['nuid'] != '') AND ($_POST['npasswd1'] != '') AND ($_POST['npasswd2'] != '')) {
        if ($_POST['npasswd1'] == $_POST['npasswd2']) {
            $id = $_POST['nuid'];
            if (dublicate($db, $id) == true)  $errmsg = '<p style="color: red; text-align:center;">Such name already exists!</p>';
            else {
                $_SESSION['uid'] = $id;
                $stmt = addUser($db, $id);
                $stmt = setPoints($db, $id);
                $_SESSION['in']=1;
                $_SESSION['signin']=0;
                $_SESSION['app2_islogged'] = true;
            }
        }
        else $errmsg = '<p style="color: red; text-align:center;">Passwords are different!</p>';
    }
    else $errmsg = '<p style="color: red; text-align:center;">Fullfill all information!</p>';
}

//showing highscores
if (isset($_POST['scores']))
{
    if ($_SESSION['points'] == 0) $_SESSION['points'] = 1; else $_SESSION['points'] = 0;
}

//making sql request to get points from database
function haePoints($db, $id) {
    $sql = <<<SQLEND
   SELECT  part.name, capital, flag, animal, flower from points 
   INNER JOIN part WHERE points.part_id = part.id AND points.user_id=:id
SQLEND;

   $stmt = $db->prepare($sql);
   $stmt->bindValue(':id', "$id", PDO::PARAM_STR);
   $stmt->execute();
   return $stmt;
}


//printing result of sql request
function printPoints($stmt) { 
    $row_count = $stmt->rowCount();
    echo "<table border='1'>\n";    
    $output = <<<OUTPUTEND
    <tr>
    <td>Part</td><td>Capital</td><td>Flag</td><td>Animal</td><td>Flower</td>
    </tr>
OUTPUTEND;
    echo $output;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $output = <<<OUTPUTEND
        <tr>
        <td>{$row['name']}</td><td>{$row['capital']}</td><td>{$row['flag']}</td>
        <td>{$row['animal']}</td><td>{$row['flower']}</td>
       </tr>
OUTPUTEND;
        echo $output;
    }
    echo "</table>\n";
}

//adding new user
function addUser($db, $id) {
   $sql = <<<SQLEND
   INSERT INTO user VALUES('$_POST[nuid]','$_POST[npasswd1]')
SQLEND;
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':id', "$id", PDO::PARAM_STR);
   $stmt->execute();
   return $stmt;    
}

//checking does username already exists
function dublicate($db, $id) {
    $sql = <<<SQLEND
   SELECT * FROM user WHERE id LIKE :id
SQLEND;
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':id', "$id", PDO::PARAM_STR);
   $stmt->execute();
   $row_count = $stmt->rowCount();
   if ($row_count == 1) return true; else return false;
}

//setting all points to 0 for new user
function setPoints($db, $id) {
   $sql = <<<SQLEND
   INSERT INTO points VALUES
    ('$_SESSION[uid]', 1, 0, 0, 0, 0),
    ('$_SESSION[uid]', 2, 0, 0, 0, 0),
    ('$_SESSION[uid]', 3, 0, 0, 0, 0)
SQLEND;
   $stmt = $db->prepare($sql);
   $stmt->bindValue(':id', "$id", PDO::PARAM_STR);
   $stmt->execute();
   return $stmt;  
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Around the World</title>
    <link href="css/main.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <?php include('php/navbar.php'); ?>
    <form action = 'main.php' method='post'>
    <div id="page">
        <div id="left">
            <!-- shows loing inputs -->
            <div id="login" style="display:<?php if ($_SESSION['login'] == 1) echo 'none'; else echo 'block';?>">
                <table>
                    <tr><td><span>Login:</span></td><td><input type="text" name="uid"></td></tr>
                    <tr><td><span>Password:</span></td><td><input type="password" name="passwd"></td></tr>
                    <tr><td><input type="submit" name="action" value="Login"></td><td><input type="submit" name="sign" value="Sign in"></td></tr>
                </table> 
                <?php echo $errmsg; ?>
            </div>
            <div id="signin" style="display:<?php if ($_SESSION['signin'] == 0) echo 'none'; else echo 'block';?>">
                <p> Write your username and password: </p>
                <table>
                    <tr><td><span>Login:</span></td><td><input type="text" name="nuid"></td></tr>
                    <tr><td><span>Password:</span></td><td><input type="password" name="npasswd1"></td></tr>
                    <tr><td><span>Password:</span></td><td><input type="password" name="npasswd2"></td></tr>
                    <tr><td><input type="submit" name="accept" value="Accept"></td><td><input type="submit" name="cancel" value="Cancel"></td></tr>
                </table> 
                <?php echo $errmsg; ?>
            </div>
            <!-- shows who is user and highscores after loging in -->
            <div id="in" style="display:<?php if ($_SESSION['in'] == 0) echo 'none'; else echo 'block';?>">
                <?php
                    echo "<p id='puid'>Hello, <b>" . $_SESSION['uid'] . "</b>!</p>";
                ?>
                <input type="submit" name="scores" value="Show highscores">
                <input type="submit" name="out" value="Logout">
                
                <!-- shows on click points talbe -->
                <div id="scores" style="display:<?php if ($_SESSION['points'] == 0) echo 'none'; else echo 'block';?>">
                    <?php
                        $id = $_SESSION['uid'];
                        $stmt = haePoints($db, $id);
                        printPoints($stmt);
                    ?>
                </div>
            </div>
        </div>
        
        <!-- shows just text about this page -->
        <div id="right">
            <p>
                Welcome to the page where you can look main information about some countries. Also you can enjoy playing game "Flag" and checking your knowledges about countries. We hope you will enjoy it.
            </p>
            <hr>
            <a id="report" href="report.php"> Report </a>
        </div>
    </div>
    </form>
  </body>
</html>
