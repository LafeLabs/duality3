 <!doctype html>
<html  lang="en">
<head>
    <meta charset="utf-8"> 
 <!-- 
PUBLIC DOMAIN, NO COPYRIGHTS, NO PATENTS.
-->
<title>Duality Editor</title>
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
<div id = "filediv" style = "display:none"><?php
    if(isset($_GET['file'])){
        echo $_GET['file'];
    }
?></div>

<div id = "square">
    <img id = "bottomimage"/>
    <img id = "topimage"/>
</div>
<div id = "notsquare">
    <a href = "editor.php">editor.php</a>
    <a href = "duality.php">duality.php</a>
    <a href = "feed.php">feed.php</a>
    <a href = "index.html">index.html</a>
    <a href = "replicate.html">replicate.html</a>
<table>
    <tr>
        <td>top image url:</td>
        <td><input id = "topimageurl"/></td>
        <td class = "selectbutton" id = "topimageselect"></td>
    </tr>
    <tr>
        <td>bottom image url:</td>
        <td><input id = "bottomimageurl"/></td>
        <td  class = "selectbutton" id = "bottomimageselect"></td>
    </tr>
    <tr>
        <td class = "sliderbar" colspan="3" id = "scaleslider">S C A L E<img/></td>
    </tr>
    <tr>
        <td class = "sliderbar" colspan="3" id = "rotateslider">R O T A T E<img/></td>
    </tr>
    <tr>
        <td class = "button" colspan="3" id = "publishbutton">P U B L I S H<img/></td>
    </tr>

</table>
</div>
<script>

if(document.getElementById("filediv").innerHTML.length > 0){
    fileset = true;
}
else{
    fileset = false;
}

select = "top";
document.getElementById("topimageselect").style.backgroundColor="green";

duality = JSON.parse(document.getElementById("datadiv").innerHTML);
theta = duality.theta;
alpha = Math.cos(theta)*Math.cos(theta);
beta = Math.sin(theta)*Math.sin(theta);

x = duality.top.x;
y = duality.top.y;
w = duality.top.w;
angle = duality.top.angle;


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

    if(select == "top"){
        duality.top.x = (x*square + ev.deltaX)/square;
        duality.top.y = (y*square + ev.deltaY)/square;
        document.getElementById("topimage").style.left = (x*square + ev.deltaX).toString() + "px";
        document.getElementById("topimage").style.top = (y*square + ev.deltaY).toString() + "px";     
    }
    else{
        duality.bottom.x = (x*square + ev.deltaX)/square;
        duality.bottom.y = (y*square + ev.deltaY)/square;
        document.getElementById("bottomimage").style.left = (x*square + ev.deltaX).toString() + "px";
        document.getElementById("bottomimage").style.top = (y*square + ev.deltaY).toString() + "px";             
    }

});    

mc1 = new Hammer(document.getElementById("scaleslider"));
mc1.get('pan').set({ direction: Hammer.DIRECTION_ALL });
mc1.on("panleft panright panup pandown tap press", function(ev) {
    
    if(select == "top"){
        document.getElementById("topimage").style.width = (ev.deltaX + w*square).toString() + "px";
        duality.top.w = (ev.deltaX + w*square)/square;
    }
    else{
        document.getElementById("bottomimage").style.width = (ev.deltaX + w*square).toString() + "px";
        duality.bottom.w = (ev.deltaX + w*square)/square;
    }

});

mc2 = new Hammer(document.getElementById("rotateslider"));
mc2.get('pan').set({ direction: Hammer.DIRECTION_ALL });
mc2.on("panleft panright panup pandown tap press", function(ev) {
    
    if(select == "top"){
        document.getElementById("topimage").style.transform = "rotate(" + (angle + ev.deltaX*Math.PI/10).toString() + "deg)";
        duality.top.angle = angle + ev.deltaX*Math.PI/10;
    }
    else{
        document.getElementById("bottomimage").style.transform = "rotate(" + (angle + ev.deltaX*Math.PI/10).toString() + "deg)";
        duality.bottom.angle = angle + ev.deltaX*Math.PI/10;    
    }


});


document.getElementById("bottomimageselect").onclick = function(){
    select = "bottom";
    document.getElementById("topimageselect").style.backgroundColor="white";

    document.getElementById("bottomimageselect").style.backgroundColor="green";
    x = duality.bottom.x;
    y = duality.bottom.y;
    w = duality.bottom.w;
    angle = duality.bottom.angle;

}

document.getElementById("topimageselect").onclick = function(){
    select = "top";
    document.getElementById("topimageselect").style.backgroundColor="green";
    document.getElementById("bottomimageselect").style.backgroundColor="white";
    x = duality.top.x;
    y = duality.top.y;
    w = duality.top.w;
    angle = duality.top.angle;

}

document.getElementById("topimageurl").onchange = function(){
    document.getElementById("topimage").src = this.value;
    duality.top.src = this.value;
}
document.getElementById("bottomimageurl").onchange = function(){
    document.getElementById("bottomimage").src = this.value;
    duality.bottom.src = this.value;
}

document.getElementById("publishbutton").onclick = function(){

    data = encodeURIComponent(JSON.stringify(duality,null,"    "));
    var httpc = new XMLHttpRequest();
    var url = "filesaver.php";        
    httpc.open("POST", url, true);
    httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
    httpc.send("data=" + data + "&filename=data/duality.txt");//send text to filesaver.php    

    var timestamp = Math.round((new Date().getTime())/1000).toString();
    var httpc2 = new XMLHttpRequest();
    var url = "filesaver.php";        
    httpc2.open("POST", url, true);
    httpc2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
    httpc2.send("data=" + data + "&filename=feed/duality" + timestamp + ".txt");//send text to filesaver.php    
    
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
.selectbutton{
    border:solid;
    border-width:3px;
    border-radius:3px;
    width:1em;
    height:1em;
    cursor:pointer;
}
.selectbutton:hover{
    border-color:green;
}
.sliderbar{
    border:solid;
    height:1em;
}
.button{
    cursor:pointer;
    border:solid;
    border-width:3px;
    border-radius:3px;
    height:1em;
}
.button:hover{
    background-color:green;
}
.button:active{
    background-color:yellow;
}

</style>
</body>
</html>