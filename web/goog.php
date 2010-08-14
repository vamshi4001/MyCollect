<?php

include('lib/html_php_parser.php');
ini_set ('allow_url_fopen', '1');
ini_set('user_agent',"MyCollect/1.0");

$url='http://google.com/search?q='.rawurlencode($_GET['q']);
$html = file_get_html($url);
$totalres = $html->find('p[id=resultStats] b',2)->plaintext;
$showing = $html->find('p[id=resultStats] b',1)->plaintext;
echo '<head><base target="_blank"></head>';
echo "<h3>Google Search results for ' ".$_GET['q']." ' </h3>";

echo '<strong>Showing top: '.$showing.' | Total Results: '.$totalres.'</strong>';



$content = $html->find('div[id=res] div',0);
$content = str_replace('/search','http://google.com/search',$content);
echo $content;

?>