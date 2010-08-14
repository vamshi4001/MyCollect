<?php

include('lib/html_php_parser.php');
ini_set ('allow_url_fopen', '1');
ini_set('user_agent',"MyCollect/1.0");
 
// get DOM from URL or file
$url='http://delicious.com/search?p='.rawurlencode($_GET['q']).'&chk=&context=main|&fr=del_icio_us&lc=&page=1';
$html = file_get_html($url);

// find all link
$tagCount = 0;
$bookCount=1;
echo '<head><meta charset=utf-8><base target="_blank"></head>';
echo '<h3>Found '.$html->find('EM',5)->plaintext.' Bookmarks @ del.icio.us for '.$_GET['q'].' </h3>';

$tagdisplay = $html->find('DIV.tagdisplay');
$books=$html->find('A[class=taggedlink]');
$taglist="";



foreach(  $tagdisplay as $tag){
$tags="";

	foreach( $tag->find('li a') as $inner )
		$tags.= $inner.' ,';
	$tags = str_replace('/tag/','http://delicious.com/tag/',$tags);		
	$taglist[$tagCount] = $tags;
	$tagCount = $tagCount+1;
	
	}


foreach($books as $e) {
	$f=$e;
	$tag_tree="";
	echo $bookCount.". ".$f.'<br><ul>tags:- ';
	echo $taglist[$bookCount].'</ul><br>';

	$bookCount=$bookCount+1;
	
	}
	


?>