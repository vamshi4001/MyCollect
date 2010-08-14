<?php
$q=$_GET["q"];
#echo '<head>'.$q.'</head>';
$tweet='social/twitter.php?q='.$q;
$del='social/del.php?q='.$q;
$flickr='social/flickr.php?q='.$q;

echo        '<frameset cols="50%,50%,50%">';
	echo '<frame src="'.$tweet.'" frameborder="0" scrolling="auto" noresize="yes" target="_blank" /> ';
	
  echo '  <frame src="'.$del.'" frameborder="0" scrolling="auto" noresize="yes" target="_blank" />
	<frame src="'.$flickr.'" frameborder="0" scrolling="auto" noresize="yes" target="_blank" />
	</frameset>
    
	</body> ';
	?>
	
	
	