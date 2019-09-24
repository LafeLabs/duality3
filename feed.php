 <!doctype html>
<html>
<head>
 <!-- 
PUBLIC DOMAIN, NO COPYRIGHTS, NO PATENTS.
-->
<title>Duality Feed</title>
</head>
<body>
<div id = "datadiv" style = "display:none"><?php

$feedfiles = scandir(getcwd()."/feed");

echo "[\n";
$feedindex = 0;
foreach($feedfiles as $value){
    if($value{0} != "."){
        echo file_get_contents("feed/".$value);
        if($feedindex < count($feedfiles) - 3){
            echo ",\n";
        }
        $feedindex = $feedindex + 1;
    }
}

echo "]";

?></div>



<div id = "feedscroll">

</div>

<script>
squaresize = window.innerWidth/2;

feed = JSON.parse(document.getElementById("datadiv").innerHTML);

for(var index = 0;index < feed.length;index++){
    var newsquare = document.createElement("DIV");
    newsquare.style.width = squaresize.toString() + "px";
    newsquare.style.height = squaresize.toString() + "px";

    newsquare.className = "square";
    document.getElementById("feedscroll").appendChild(newsquare);
    var newtop = document.createElement("IMG");
    newtop.style.zIndex = -1;
    var newbottom = document.createElement("IMG");
    newbottom.style.zIndex = -2;
    newsquare.appendChild(newtop);
    newsquare.appendChild(newbottom);
    newtop.src = feed[index].top.src;
    newbottom.src = feed[index].bottom.src;
    newtop.style.width = (feed[index].top.w*squaresize).toString() + "px";
    newtop.style.left = (feed[index].top.x*squaresize).toString() + "px";
    newtop.style.top = (feed[index].top.y*squaresize).toString() + "px";
    newbottom.style.width = (feed[index].bottom.w*squaresize).toString() + "px";
    newbottom.style.left = (feed[index].bottom.x*squaresize).toString() + "px";
    newbottom.style.top = (feed[index].bottom.y*squaresize).toString() + "px";

    newtop.style.transform = "rotate(" + (feed[index].top.angle).toString() + "deg)";
    newbottom.style.transform = "rotate(" + (feed[index].bottom.angle).toString() + "deg)";

}


</script>
<style>
.square{
    display:block;
    margin:auto;
    position:relative;
    overflow:hidden;
    border:solid;
}
.square img{
    position:absolute;
    opacity:0.5;
}

</style>

</body>
</html>