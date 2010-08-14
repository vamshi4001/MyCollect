<?php
$q=$_GET["q"];
#echo '<head>'.$q.'</head>';
$yahoo='web/ysearch.php?query='.$q.'&type=web';
$goog='web/goog.php?q='.$q;
$bing='web/bing.php?searchTerm='.$q.'&SourceType=Web&fetch=Search';

echo        '<frameset cols="50%,50%,50%">';
	echo '<frame src="'.$yahoo.'" frameborder="0" scrolling="auto" noresize="yes"/> ';
	
  echo '  <frame src="'.$goog.'" frameborder="0" scrolling="auto" noresize="yes" />
	<frame src="'.$bing.'" frameborder="0" scrolling="auto" noresize="yes" />
	</frameset>
    
	</body> ';
	?>
	
	
	