 <!doctype html>
<html  lang="en">
<head>
    <meta charset="utf-8"> 
 <!-- 
PUBLIC DOMAIN, NO COPYRIGHTS, NO PATENTS.
-->
<title>Duality</title>
<link href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAP//AP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAREAAREAAREAERAAERAAEQABEQABEQABAAAAAAAAAAAAAAAAAAAAAAAAACIiAAAAAAAiIiIiAAAAAiAAIiIgAAAAAAACIiAAAAAAAAIiIAAAACIAIgAgAAAAIgAiACAAAAAAACIiIAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAD//wAA/D8AAPAPAADgBwAAwAMAAMADAADAAwAAwAMAAMADAADAAwAA4AcAAPAPAAD8PwAA" rel="icon" type="image/x-icon" />

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
<script>

duality = JSON.parse(document.getElementById("datadiv").innerHTML);
theta = duality.theta;
alpha = Math.cos(theta)*Math.cos(theta);
beta = Math.sin(theta)*Math.sin(theta);

document.getElementById("bottomimage").src = duality.bottom.src;
document.getElementById("topimage").src = duality.top.src;


</script>

<style>

</style>
</body>
</html>