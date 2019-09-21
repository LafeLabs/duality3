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

<script>

theta = Math.PI/4;

linkimages = document.getElementById("linktable").getElementsByTagName("img");
for(var index = 0;index < linkimages.length;index++){
    linkimages[index].style.width = (innerWidth/16).toString() + "px";
}

    duality = JSON.parse(document.getElementById("datadiv").innerHTML);
    url = document.getElementById("urldiv").innerHTML;
    path = document.getElementById("pathdiv").innerHTML;
    if(path.length > 1){
        pathset = true;
    }
    else{
        pathset = false;
    }
    if(url.length > 1){
        urlset = true;
    }
    else{
        urlset = false;
    }
    
    if(urlset && !pathset){
        data = encodeURIComponent(JSON.stringify(duality,null,"    "));
        var httpc = new XMLHttpRequest();
        var url = "filesaver.php";
        httpc.open("POST", url, true);
        httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
        httpc.send("data=" + data + "&filename=" + "json/duality.txt");//send text to filesaver.php
    }
    if(urlset && pathset){
        data = encodeURIComponent(JSON.stringify(duality,null,"    "));
        var httpc = new XMLHttpRequest();
        var url = "filesaver.php";
        httpc.open("POST", url, true);
        httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
        httpc.send("data=" + data + "&filename=" + path);//send text to filesaver.php
    }    
    if(pathset){
        document.getElementById("linkerlink").href += "?path=" + path; 
        document.getElementById("alignerlink").href += "?path=" + path; 
    }
    
    W = innerWidth;
    for(var index = 0;index < duality.length;index++){
        var newimg = document.createElement("IMG");
        newimg.id = "i" + index.toString();
        newimg.className = "boximg";
        document.getElementById("page").appendChild(newimg);
        newimg.src = duality[index].src;
        newimg.style.left = (duality[index].x*W).toString() + "px";
        newimg.style.top = (duality[index].y*W).toString() + "px";
        newimg.style.width = (duality[index].w*W).toString() + "px";
        newimg.style.transform = "rotate(" + duality[index].angle.toString() + "deg)";
    }

boxes = document.getElementById("page").getElementsByClassName("boximg");
mc = new Hammer(document.getElementById("page"));
mc.get('pan').set({ direction: Hammer.DIRECTION_ALL });
mc.on("panleft panright panup pandown tap press", function(ev) {

    theta = Math.PI/4 +(ev.deltaX/200);
    redraw();

});    


redraw();
    
function redraw(){
    boxes[0].style.opacity = Math.cos(theta)*Math.cos(theta).toString();
    boxes[1].style.opacity = Math.sin(theta)*Math.sin(theta).toString();
    
}
</script>


<style>

</style>
</body>
</html>