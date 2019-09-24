 <!doctype html>
<html>
<head>
 <!-- 
PUBLIC DOMAIN, NO COPYRIGHTS, NO PATENTS.
-->
<title>Duality Feed</title>
</head>
<body>
<div id = "filesdiv" style = "display:none"><?php

$feedfiles = scandir(getcwd()."/feed");

echo "[\n";
$feedindex = 0;
foreach($feedfiles as $value){
    if($value{0} != "."){
        echo "\"".("feed/".$value)."\"";
        if($feedindex < count($feedfiles) - 3){
            echo ",\n";
        }
        $feedindex = $feedindex + 1;
    }
}

echo "]";

?></div>
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
files = JSON.parse(document.getElementById("filesdiv").innerHTML);


for(var index = 0;index < feed.length;index++){
    var newsquare = document.createElement("DIV");
    newsquare.style.width = squaresize.toString() + "px";
    newsquare.style.height = squaresize.toString() + "px";

    newsquare.className = "square";
    var newbox = document.createElement("DIV");
    newbox.className = "squarebox";
    
    document.getElementById("feedscroll").appendChild(newbox);
    newbox.appendChild(newsquare);
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
    newsquare.id = files[index];
    newsquare.onclick = function(){
        location.href = "duality.php?file=" + this.id;
    }


    var newdelete = document.createElement("IMG");
    newdelete.src = "iconsymbols/deletebutton.svg";
    newbox.appendChild(newdelete);
    newdelete.className = "deletebutton";
    newdelete.onclick  =  function(){
        document.getElementById("feedscroll").removeChild(this.parentNode);
        //delete the file...
        localfilename = this.parentNode.getElementsByClassName("square")[0].id;
        //alert(localfilename);
        var httpc = new XMLHttpRequest();
        var url = "deletefile.php";         
        httpc.open("POST", url, true);
        httpc.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8");
        httpc.send("filename=" + localfilename);//send text to deletefile.php
                
        
    }
    
    var newjsonbutton = document.createElement("IMG");
    newjsonbutton.src = "iconsymbols/jsonicon.svg";
    newbox.appendChild(newjsonbutton);
    newjsonbutton.className = "jsonbutton";
    newjsonbutton.onclick = function(){

        localfilename = this.parentNode.getElementsByClassName("square")[0].id;
        
        location.href = localfilename;
        
    }
    
}


</script>
<style>
.square{
    display:block;
    margin:auto;
    position:relative;
    overflow:hidden;
    border:solid;
    cursor:pointer;
}
.square img{
    position:absolute;
    opacity:0.5;
}
.deletebutton{
    position:absolute;
    top:50%;
    width:100px;
    right:0px;
    z-index:1;
    cursor:pointer;
}
.jsonbutton{
    position:absolute;
    top:50%;
    width:100px;
    left:0px;
    z-index:1;
    cursor:pointer;
    
}
.squarebox{
    border:solid;
    position:relative;
}
</style>

</body>
</html>