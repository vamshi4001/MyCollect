<?php 
$q=$_GET["q"];
echo '<html>
<head>
<meta charset=utf-8>
</head>
<body>
<a href="content.php?q='.$q.'" target="open_target" >All</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="scollect.php?q='.$q.'" target="open_target" >Social collect</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="wcollect.php?q='.$q.'" target="open_target" >Web Collect</a>&nbsp;&nbsp;&nbsp;
<a href="ysearch-placemark.php?q='.$q.'" target="open_target" >News HotSpot</a>&nbsp;&nbsp;&nbsp;
</body>
</html>';

?>