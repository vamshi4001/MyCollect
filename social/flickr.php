<?php
// example of how to use basic selector to retrieve HTML contents
include('lib/html_php_parser.php');
ini_set ('allow_url_fopen', '1');
ini_set('user_agent',"MyCollect/1.0");
echo '<head><base target="_blank"><meta charset=utf-8></head>';
 echo '<h3>Flickr Results for "'.$_GET['q'].' "</h3>';
// get DOM from URL or file
$url='http://www.flickr.com/search/?q='.$_GET['q'].'&w=all';
$html = file_get_html($url);

// find all link
$count = 1;
foreach($html->find('Div.ResultsThumbs') as $e) {
	$e=str_replace('/photos','http://flickr.com/photos/',$e);
	echo $e;

	
	
	}
	
	
	


?>