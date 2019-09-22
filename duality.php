 <!doctype html>
<html  lang="en">
<head>
    <meta charset="utf-8"> 
 <!-- 
PUBLIC DOMAIN, NO COPYRIGHTS, NO PATENTS.
-->
<title>Duality</title>
<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAP//AP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAREAAREAAREAERAAERAAEQABEQABEQABAAAAAAAAAAAAAAAAAAAAAAAAACIiAAAAAAAiIiIiAAAAAiAAIiIgAAAAAAACIiAAAAAAAAIiIAAAACIAIgAgAAAAIgAiACAAAAAAACIiIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD//wAA/D8AAPAPAADgBwAAwAMAAMADAADAAwAAwAMAAMADAADAAwAA4AcAAPAPAAD8PwAA" rel="icon" type="image/x-icon" />
<script src = "https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.js"></script>
</head>
<body>
<div id = "datadiv" style = "display:none"><?php
    if(isset($_GET['file'])){
        echo file_get_contents($_GET['file']);
    }
    else{
        echo file_get_contents("data/duality.txt");        
    }
?></div>

<div id = "square">
    <img id = "bottomimage"/>
    <img id = "topimage"/>
</div>
<div id = "notsquare">
    <a href = "editor.php">editor.php</a>
    <a href = "dualityeditor.php">dualityeditor.php</a>
    <a href = "index.html">index.html</a>
</div>
<script>

duality = JSON.parse(document.getElementById("datadiv").innerHTML);
theta = duality.theta;
alpha = Math.cos(theta)*Math.cos(theta);
beta = Math.sin(theta)*Math.sin(theta);

document.getElementById("bottomimage").src = duality.bottom.src;
document.getElementById("topimage").src = duality.top.src;

if(window.innerWidth > window.innerHeight){
    square = window.innerHeight;
    document.getElementById("notsquare").style.width = (window.innerWidth - square).toString() + "px";
    document.getElementById("notsquare").style.height = (square).toString() + "px";
    
}
else{
    square = window.innerWidth;
    document.getElementById("notsquare").style.height = (window.innerHeight - square).toString() + "px";
    document.getElementById("notsquare").style.width = (square).toString() + "px";
    
}

document.getElementById("square").style.width = square.toString() + "px";
document.getElementById("square").style.height = square.toString() + "px";


document.getElementById("topimage").style.width = (square*duality.top.w).toString() + "px";
document.getElementById("bottomimage").style.width = (square*duality.bottom.w).toString() + "px";
document.getElementById("topimage").style.left = (square*duality.top.x).toString() + "px";
document.getElementById("bottomimage").style.left = (square*duality.bottom.x).toString() + "px";
document.getElementById("topimage").style.top = (square*duality.top.y).toString() + "px";
document.getElementById("bottomimage").style.top = (square*duality.bottom.y).toString() + "px";


document.getElementById("topimage").style.transform = "rotate(" + (duality.top.angle).toString() + "deg)";
document.getElementById("bottomimage").style.transform = "rotate(" + (duality.bottom.angle).toString() + "deg)";

document.getElementById("topimage").style.opacity = (alpha).toString();
document.getElementById("bottomimage").style.opacity = (beta).toString();


mc = new Hammer(document.getElementById("square"));
mc.get('pan').set({ direction: Hammer.DIRECTION_ALL });
mc.on("panleft panright panup pandown tap press", function(ev) {

    theta = Math.PI/4 +(ev.deltaX/200);
    redraw();

});    

function redraw(){

    alpha = Math.cos(theta)*Math.cos(theta);
    beta = Math.sin(theta)*Math.sin(theta);
    document.getElementById("topimage").style.opacity = (alpha).toString();
    document.getElementById("bottomimage").style.opacity = (beta).toString();
    
}
</script>

<style>
#notsquare{
    position:absolute;
    top:0px;
    right:0px;
    z-index:0;
}
#square{
    position:absolute;
    bottom:0px;
    left:0px;
    z-index:0;
}
#square img{
    position:absolute;
}
#bottomimage{
    z-index:-2;
}
#topimage{
    z-index:-1;
}

</style>
</body>
</html>