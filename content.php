<?php
$q=$_GET["q"];
#echo '<head>'.$q.'</head>';
$tweet='social/twitter.php?q='.$q;
$yahooimg='web/ysearchimages.php?query='.$q.'&type=image';
$yahoonews='web/ysearchnews.php?query='.$q.'&type=news';
$wiki='misc/wiki.php?q='.$q;
echo '<head><meta charset=utf-8><base target="_blank"></head>';


echo        '<frameset cols="50%,50%,50%">';
	echo '<frame src="'.$wiki.'" frameborder="0" scrolling="auto" noresize="yes" target="_blank" />
		  <frame src="'.$yahooimg.'" frameborder="0" scrolling="auto" noresize="yes" target="_blank" /> 			
		  <frame src="'.$yahoonews.'" frameborder="0" scrolling="auto" noresize="yes" target="_blank" />
		  
 
	
	</frameset>
    
	</body> ';
	?>