var link = [
    {name: '#a1', value: true, color: '#B60E0E'},
    {name: '#a2', value: false, color: '#32C436'},
    {name: '#a3', value: false, color: '#95910A'},
    {name: '#a4', value: false, color: '#D87223'},
    {name: '#a5', value: true, color: '#B60E0E'},
    {name: '#a6', value: false, color: '#32C436'},
    {name: '#a7', value: false, color: '#95910A'},
    {name: '#a8', value: false, color: '#D87223'}
]

var descriptions = [
    "This project is a game written in C# XML. In the game player needs to find 3 keys in each room to move forward. In the project are used models for rooms and objects with description of their behavior. For interaction with the player are used static classes with messages and actions. There is timer in the game so it is possible to lose.",
    "This page is about countries of Europe, Asia and Africa and their national things. There is session work made with PHP, so you can log or sign in, there is data base written with MySQL. Information about countries is made with React, Quiz is made with PHP, data about it is saved to database. Flag game is made with Javascript.",
    "This is the game made in Unity. The goal of the game is to stand on blocks with required color. There are used ready character and animations as well as player controller script. Everything else is made by myself: scripts which generate levels and pick up objects for speed up boost, camera's behavior and light.",
    "This project is done in Android Studio with Kotlin. This application for phones with android which loads pictures from internet by url, they come as list of clickable preview images and it's possible to view picture by picture. Each picture can be seen in full screen mode and downloaded to the phone memory.",
    "This project is mobile application made in QT Creator. It is app where is possible to create and manage notes. Notes can be created to any day chosen from calendar. They are shown in collapsed list which can be expanded by click. Also in application are toast notification and notification to the screen."
]

var indexs = []

$(document).ready(function(){
    nav("#a1");
    nav("#a2");
    nav("#a3");
    nav("#a4");
    nav("#a5");
    nav("#a6");
    nav("#a7");
    nav("#a8");
    $(".icon").mouseenter(function(){
        $(this).css("cursor", "pointer");
    });
});

function nav(a) {
    $(a).click(function(){
        $(".links").css("background", "#1A120A");
        $(".icon2").css("display", "none");
        for(i=0;i<8;i++){
            if (link[i].name == a) {
                link[i].value = true;
                $(this).css("background", link[i].color);
                $(this).children().css("display", "block");
            }
            else
                link[i].value = false;
        }
    }).mouseenter(function(){
        for(i=0;i<8;i++){
            if (link[i].name == a) {
                $(this).css("background", link[i].color);
                $(this).children().css("display", "block");
            }
        }
    }).mouseleave(function() {
        for(i=0;i<8;i++){
            if (link[i].name == a && link[i].value == false) {
                $(this).css("background", "#1A120A");
                $(this).children().css("display", "none");
            }
        }
    });
}


function show(index) {  
        switch(index){
            case 0:
                x = document.getElementsByClassName("minipage");
                changeStyle(x);
                a = document.getElementById("home");
                a.style.display = "block";
                break;
            case 1:
                x = document.getElementsByClassName("minipage");
                changeStyle(x);
                a = document.getElementById("resume");
                a.style.display = "block"; 
                break;
            case 2:
                x = document.getElementsByClassName("minipage");
                changeStyle(x);
                a = document.getElementById("skills");
                a.style.display = "block";   
                break;
            case 3:
                x = document.getElementsByClassName("minipage");
                changeStyle(x);
                a = document.getElementById("projects");
                a.style.display = "block";  
                break;
        }
    }

function changeStyle(x) {
        for(i=0; i<x.length; i++) {
            x[i].style.display = "none";
        } 
    }

function changeColor(x) {
    for(i=0; i<x.length; i++) {
            x[i].style.backgroundColor = "#1A120A";
        } 
}

function showProjects(x) {
    $("#projectmenu").css("display", "none");
    $("#project").css("display", "flex");
    switchProject(x);
}

function switchProject(x) {
    $("#mini").empty();
    $("#icons").empty();
    $("#singlePRJimg").attr("src","pictures/projects/" + x + ".JPG");
    $("#description").text(descriptions[x-1]);
    var img = $("<img id='git' src='pictures/github.svg' />");
    $("#icons").append(img);
    var img = $("<img id='folder' src='pictures/folder.svg' />");
    $("#icons").append(img);
    $("#git").on('click', function(){openGit(x)});
    $("#folder").on('click', function(){openFolder(x)});
    indexs = [];
    for (i=1; i<6; i++) {
        if (i!=x) {
            indexs.push(i);
        }
    }
    for(i=0; i<4; i++) {
        var img = $("<img class='imgmini'/>");
        $("#mini").append(img);
    }
    $( ".imgmini" ).each(function( index ) {
        $(this).attr('src', "pictures/projects/" + indexs[index] + ".JPG");
        $(this).on('click', function(){switchProject(indexs[index])})
    });
}

function openGit(index) {
    switch(index){
        case 1:
            var win = window.open("https://github.com/K8760/Olio-ohjelmointi/tree/master/harjoitus/harjoitus", '_blank');
            win.focus();
            break;
        case 2:
            var win = window.open("https://github.com/K8760/JavaScript-PHP/tree/master/harjoitustyo", '_blank');
            win.focus();
            break;
        case 3:
            var win = window.open("https://github.com/K8760/Peliohjelmointi/tree/master/Harkka", '_blank');
            win.focus();
            break;
        case 4:
            var win = window.open("https://github.com/K8760/Android/tree/master/Harkka", '_blank');
            win.focus();
            break;
        case 5:
            var win = window.open("https://github.com/K8760/Qt", '_blank');
            win.focus();
            break;
    }
}

function openFolder(index) {
    switch(index){
        case 1:
            var win = window.open("https://student.labranet.jamk.fi/~K8760/projects/c-sharp/", '_blank');
            win.focus();
            break;
        case 2:
            var win = window.open("https://student.labranet.jamk.fi/~K8760/harjoitustyo/main.php", '_blank');
            win.focus();
            break;
        case 3:
            var win = window.open("https://student.labranet.jamk.fi/~K8760/projects/colorBlock/", '_blank');
            win.focus();
            break;
        case 4:
            var win = window.open("https://www.youtube.com/watch?v=pJAcdYEQjuE", '_blank');
            win.focus();
            break;
        case 5:
            var win = window.open("https://www.youtube.com/watch?v=x-nvSsw40CQ", '_blank');
            win.focus();
            break;
    }
}

function openPage(index) {
    switch(index){
        case 1:
            var win = window.open("https://www.linkedin.com/in/ekaterina-piispanen-785a29137/", '_blank');
            win.focus();
            break;
        case 2:
            var win = window.open("https://github.com/K8760", '_blank');
            win.focus();
            break;
        case 3:
            var win = window.open("https://www.facebook.com/kate.piispanen", '_blank');
            win.focus();
            break;
    }
}