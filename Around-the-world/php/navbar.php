<div style="height:200px;">
    <div id="head">
        <img id="glob" src="pictures/main.png">
        <?php if ($_SESSION['mainpage'] == true) echo "<h1>Around the World</h1>" ?>
        <?php if ($_SESSION['quizpage'] == true) echo "<h1>Country QUIZ</h1>" ?>
        <?php if ($_SESSION['flagpage'] == true) echo "<h1>Flag GAME</h1>" ?>
    </div>
    <nav>
        <ul>
            <li><a href="main.php">Menu</a></li>
            <li><a href="info.php">Information</a></li>
            <li><a href="quiz.php" name="quiz">Quiz</a></li>
            <li><a href="flag.php">Flag game</a></li>
        </ul>
    </nav>
    <div id="empty"></div>
</div>