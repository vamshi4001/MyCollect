<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">

<html>
<title> My Collect | Alpha  </title>
<meta charset=utf-8>
<?php 
$q=$_GET["q"];

echo '<frameset rows="10%,5%,85%">';
echo '<frame src="head.html" frameborder="0" scrolling="no" noresize="yes"/>';
echo '<frame src="cat.php?q='.$q.'" frameborder="0" scrolling="no" noresize="yes" /> ';
echo '<frame src="content.php?q='.$q.'"  frameborder="0" scrolling="auto" noresize="yes" name="open_target" />';
echo'</frameset>';
	
?>
</html>
	