$(document).ready(function(){
    $("h1").click(function(){
        $(this).siblings("p").toggle();
        $(this).siblings("h3").toggle();
        $(this).siblings("h4").toggle();
        $(this).siblings("img").toggle();
        $(this).siblings("ul").toggle();
    });
});