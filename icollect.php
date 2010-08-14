<?php
$q=$_GET["q"];
#echo '<head>'.$q.'</head>';
$yimage='web/ysearch.php?query='.$q.'&type=image';
$gimage='web/goog.php?q='.$q;
$bimage='web/bing.php?searchTerm='.$q.'&SourceType=Images&fetch=Search';

echo        '<frameset cols="50%,50%,50%">';
	echo '<frame src="'.$yimage.'" frameborder="0" scrolling="auto" noresize="yes" target="_blank" /> ';
	
  echo '  <frame src="'.$gimage.'" frameborder="0" scrolling="auto" noresize="yes" target="_blank" />
	<frame src="'.$bimage.'" frameborder="0" scrolling="auto" noresize="yes" target="_blank" />
	</frameset>
    
	</body> ';
	?>
	