function FunctionIconMobile(x) {
    x.classList.toggle("change");

}
$(document).ready(function(){
    $(".containerBarreMobile").click(function(){
        $("#navId").fadeToggle();
    });
});



function resizeNavBar(x) {
    if (x.matches) {
        document.getElementById("navId").style.display = "none";
        if(document.getElementById("ctb").classList.contains("change") == true)
            document.getElementById("ctb").classList.remove("change");

    } else {
        document.getElementById("navId").style.display = "flex";

    }
}

var x = window.matchMedia("(max-width: 767.98px)")
resizeNavBar(x)
x.addEventListener(resizeNavBar)