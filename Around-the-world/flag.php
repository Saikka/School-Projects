<?php
 
session_start();
$_SESSION['mainpage'] = false;
$_SESSION['quizpage'] = false;
$_SESSION['flagpage'] = true;
$_SESSION['report'] = false;
 
?>
 
 
<!DOCTYPE html>
<html>
<head>
    <link href="css/flag.css" rel="stylesheet" type="text/css" />
    <title>Flag GAME</title>
    <script>
 
        const PUZZLE_DIFFICULTY = 3; // 4x4=16 palasta
        const PUZZLE_HOVER_TINT = '#009900';

        var stage;
        var canvas;
        //var img;
        var pieces;
        var puzzleWidth;
        var puzzleHeight;
        var pieceWidth;
        var pieceHeight;
        var currentPiece;
        var currentDropPiece;  
        var mouse;
        
        countries = new Array();
        pictures = new Array();
        //number = new Array();
        index = 0;

            // funktiota kutsutaan web-sivulta bodyn onload-tapahtumasta
            function loadJSON() {
                ajax("json/countries.json", function(response) {
                    //console.log("response = " + response);
                    // create a json object
                    var JSONObject = JSON.parse(response);
                    countries1 = JSONObject.Europe;
                    countries2 = JSONObject.Asia;
                    countries3 = JSONObject.Africa;
                    countries = countries1.concat(countries2);
                    countries = countries.concat(countries3);
                    console.log(countries.length);
                    console.log(countries);
                    p = new Array(countries.length);
                    for (var i=0; i<countries.length;i++)
                    {
                        p[i] = countries[i].image;
                    }
                    pictures = p;
                    for (number=[],i=0;i<countries.length;++i) number[i]=i;
                    number = shuffle(number);
                });
            }
            
            function ajax(url, fn) {
                var req;
                if (window.XMLHttpRequest) {
                    req = new XMLHttpRequest();
                } else {
                    req = new ActiveXObject('Microsoft.XMLHTTP');
                }
                req.onreadystatechange = function() {
                    if (req.readyState == 4 && req.status == 200) {
                        fn(req.responseText);
                    }
                }
                req.open('GET', url, true);
                req.send();
            }
            
            function shuffle(array) {
                      var tmp, current, top = array.length;
                      if(top) while(--top) {
                        current = Math.floor(Math.random() * (top + 1));
                        tmp = array[current];
                        array[current] = array[top];
                        array[top] = tmp;
                      }
                      return array;
            }

        // lataa kuvan
        function init(){
            if (index < pictures.length) {
                img = new Image();
                img.addEventListener('load',onImage,false);
                console.log(index);
                img.src = "pictures/flags/" + pictures[number[index]];
                index++;
            }
            else document.getElementById("end").innerHTML = "Game over!";
        }
        
        
        // laksetaan ja jakaa palojen koot vaikeusasteen mukaan
        function onImage(e){
            pieceWidth = Math.floor(img.width / PUZZLE_DIFFICULTY)
            pieceHeight = Math.floor(img.height / PUZZLE_DIFFICULTY)
            puzzleWidth = pieceWidth * PUZZLE_DIFFICULTY;
            puzzleHeight = pieceHeight * PUZZLE_DIFFICULTY;
            setCanvas();
            initPuzzle();
        }
        
        // canvas joka on yhtÃƒÂ¤ iso kuin kuva
        function setCanvas(){
            canvas = document.getElementById('canvas');
            stage = canvas.getContext('2d');
            canvas.width = puzzleWidth;
            canvas.height = puzzleHeight;
            canvas.style.border = "1px solid red";
            canvas.style.marginLeft = "10px";
            canvas.style.marginTop = "10px";
            //canvas.style.margin = "auto";
        }
        
        // on pelin alkutila ja palaa tÃƒÂ¤hÃƒÂ¤n kun pelataan uudelleen
        function initPuzzle(){
            pieces = [];
            mouse = {x:0,y:0};
            currentPiece = null;
            currentDropPiece = null;
            stage.drawImage(img, 0, 0, puzzleWidth, puzzleHeight, 0, 0, puzzleWidth, puzzleHeight);
            createTitle("Click to Start Puzzle");
            buildPieces();
            
        }
        
        // ohje, jolla kerrotaan kÃƒÂ¤yttÃƒÂ¤jÃƒÂ¤lle mitÃƒÂ¤ pitÃƒÂ¤ÃƒÂ¤ tehdÃƒÂ¤
        function createTitle(msg){
            stage.fillStyle = "#000000";
            stage.globalAlpha = .4;
            stage.fillRect(100,puzzleHeight - 40,puzzleWidth - 200,40);
            stage.fillStyle = "#FFFFFF";
            stage.globalAlpha = 1;
            stage.textAlign = "center";
            stage.textBaseline = "middle";
            stage.font = "20px Arial";
            stage.fillText(msg,puzzleWidth / 2,puzzleHeight - 20);
        }
        
        // maarittaa vaikeusasteen
        function buildPieces(){
            var i;
            var piece;
            var xPos = 0;
            var yPos = 0;
            for(i = 0;i < PUZZLE_DIFFICULTY * PUZZLE_DIFFICULTY;i++){
                piece = {};
                piece.sx = xPos;
                piece.sy = yPos;
                pieces.push(piece);
                xPos += pieceWidth;
                if(xPos >= puzzleWidth){
                    xPos = 0;
                    yPos += pieceHeight;
                }
            }
            document.onmousedown = shufflePuzzle;
        }
        
        // sekoittaa palaset
        function shufflePuzzle(){
            pieces = shuffleArray(pieces);
            stage.clearRect(0,0,puzzleWidth,puzzleHeight);
            var i;
            var piece;
            var xPos = 0;
            var yPos = 0;
            for(i = 0;i < pieces.length;i++){
                piece = pieces[i];
                piece.xPos = xPos;
                piece.yPos = yPos;
                stage.drawImage(img, piece.sx, piece.sy, pieceWidth, pieceHeight, xPos, yPos, pieceWidth, pieceHeight);
                stage.strokeRect(xPos, yPos, pieceWidth,pieceHeight);
                xPos += pieceWidth;
                if(xPos >= puzzleWidth){
                    xPos = 0;
                    yPos += pieceHeight;
                }
            }
            document.onmousedown = onPuzzleClick;
        }
        
        // seuraa mita palaa on clikattu
        function onPuzzleClick(e){
            if(e.layerX || e.layerX == 0){
                mouse.x = e.layerX - canvas.offsetLeft + 200;
                mouse.y = e.layerY - canvas.offsetTop + 210;
            }
            else if(e.offsetX || e.offsetX == 0){
                mouse.x = e.offsetX - canvas.offsetLeft + 200;
                mouse.y = e.offsetY - canvas.offsetTop + 210;
            }
            currentPiece = checkPieceClicked();
            if(currentPiece != null){
                stage.clearRect(currentPiece.xPos,currentPiece.yPos,pieceWidth,pieceHeight);
                stage.save();
                stage.globalAlpha = .9;
                stage.drawImage(img, currentPiece.sx, currentPiece.sy, pieceWidth, pieceHeight, mouse.x - (pieceWidth / 2), mouse.y - (pieceHeight / 2), pieceWidth, pieceHeight);
                stage.restore();
                document.onmousemove = updatePuzzle;
                document.onmouseup = pieceDropped;
            }
        }
        
        // jos ei mene muulle paikalle, pala palautetaan omalle paikalle
        function checkPieceClicked(){
            var i;
            var piece;
            for(i = 0;i < pieces.length;i++){
                piece = pieces[i];
                if(mouse.x < piece.xPos || mouse.x > (piece.xPos + pieceWidth) || mouse.y < piece.yPos || mouse.y > (piece.yPos + pieceHeight)){
                    //PIECE NOT HIT
                }
                else{
                    return piece;
                }
            }
            return null;
        }
        
        // seuraa raahattavan palan liikkumista
        function updatePuzzle(e){
            currentDropPiece = null;
            if(e.layerX || e.layerX == 0){
                mouse.x = e.layerX - canvas.offsetLeft + 200;
                mouse.y = e.layerY - canvas.offsetTop + 210;
            }
            else if(e.offsetX || e.offsetX == 0){
                mouse.x = e.offsetX - canvas.offsetLeft + 200;
                mouse.y = e.offsetY - canvas.offsetTop + 210;
            }
            stage.clearRect(0,0,puzzleWidth,puzzleHeight);
            var i;
            var piece;
            for(i = 0;i < pieces.length;i++){
                piece = pieces[i];
                if(piece == currentPiece){
                    continue;
                }
                stage.drawImage(img, piece.sx, piece.sy, pieceWidth, pieceHeight, piece.xPos, piece.yPos, pieceWidth, pieceHeight);
                stage.strokeRect(piece.xPos, piece.yPos, pieceWidth,pieceHeight);
                if(currentDropPiece == null){
                    if(mouse.x < piece.xPos || mouse.x > (piece.xPos + pieceWidth) || mouse.y < piece.yPos || mouse.y > (piece.yPos + pieceHeight)){}
                    else{
                        currentDropPiece = piece;
                        stage.save();
                        stage.globalAlpha = .4;
                        stage.fillStyle = PUZZLE_HOVER_TINT;
                        stage.fillRect(currentDropPiece.xPos,currentDropPiece.yPos,pieceWidth, pieceHeight);
                        stage.restore();
                    }
                }
            }
            stage.save();
            stage.globalAlpha = .6;
            stage.drawImage(img, currentPiece.sx, currentPiece.sy, pieceWidth, pieceHeight, mouse.x - (pieceWidth / 2), mouse.y - (pieceHeight / 2), pieceWidth, pieceHeight);
            stage.restore();
            stage.strokeRect( mouse.x - (pieceWidth / 2), mouse.y - (pieceHeight / 2), pieceWidth,pieceHeight);
        }
        
        // pala menee toiselle paikalle
        function pieceDropped(e){
            document.onmousemove = null;
            document.onmouseup = null;
            if(currentDropPiece != null){
                var tmp = {xPos:currentPiece.xPos,yPos:currentPiece.yPos};
                currentPiece.xPos = currentDropPiece.xPos;
                currentPiece.yPos = currentDropPiece.yPos;
                currentDropPiece.xPos = tmp.xPos;
                currentDropPiece.yPos = tmp.yPos;
            }
            resetPuzzleAndCheckWin();
        }
        
        // verrataan kuvaan ja todetaan onko palapeli mennyt lÃƒÂ¤pi
        function resetPuzzleAndCheckWin(){
            stage.clearRect(0,0,puzzleWidth,puzzleHeight);
            var gameWin = true;
            var i;
            var piece;
            for(i = 0;i < pieces.length;i++){
                piece = pieces[i];
                stage.drawImage(img, piece.sx, piece.sy, pieceWidth, pieceHeight, piece.xPos, piece.yPos, pieceWidth, pieceHeight);
                stage.strokeRect(piece.xPos, piece.yPos, pieceWidth,pieceHeight);
                if(piece.xPos != piece.sx || piece.yPos != piece.sy){
                    gameWin = false;
                }
            }
            if(gameWin){
                setTimeout(gameOver,500);
            }
        }
        
        // vie pelin aloitustilaan
        function gameOver(){
            document.onmousedown = null;
            document.onmousemove = null;
            document.onmouseup = null;
            initPuzzle();
        }
        
        function shuffleArray(o){
            for(var j, x, i = o.length; i; j = parseInt(Math.random() * i), x = o[--i], o[i] = o[j], o[j] = x);
            return o;
        }
         
         
 
    </script>
</head>
 
<body onload="loadJSON()">
    <?php include('php/navbar.php'); ?>
    
    <div id="page">
        <div id="root">
            <canvas id="canvas"></canvas>
        </div>
        <div id="note">
            <button id="button" type="button" onClick="init()">play</button>
            <p id="end"></p>
        </div>
    </div>
    
</body>
 
</html>