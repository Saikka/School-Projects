<?php

session_start();

//variable for navigator to know what tittle to use
$_SESSION['mainpage'] = false;
$_SESSION['quizpage'] = false;
$_SESSION['flagpage'] = false;


$prosess = false;
if (isset($_SESSION['prosess'])) if ($_SESSION['prosess'] == true) $prosess = true;

echo $prosess;
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Counties</title>
    <link href="css/info.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
      <?php include('php/navbar.php'); ?>
      <div id="page">
        <div id="root" style="display:<?php if ($prosess == true) echo 'none'; else echo 'block';?>"></div>
        <p style="display:<?php if ($prosess == false) echo 'none'; else echo 'block';?>; text-align:center;"> You can't see information while answering questions! </p>
      </div>
      <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
      <script src="https://unpkg.com/react@15.3.2/dist/react.js"></script>
      <script src="https://unpkg.com/react-dom@15.3.2/dist/react-dom.js"></script>
      <script src="https://unpkg.com/babel-core@5.8.38/browser.min.js"></script>
      <script type="text/babel" src="js/info.js"></script>
  </body>
</html>