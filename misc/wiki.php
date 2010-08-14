<?php

include('lib/html_php_parser.php');
ini_set ('allow_url_fopen', '1');
ini_set('user_agent',"MyCollect/1.0");

$url="http://en.wikipedia.org/w/index.php?title=Special:Search&search='".rawurlencode($_GET['q'])."'";
$html = file_get_html($url);

$wikisearch = $html->find('ul.mw-search-results',0);
$wikidirect = $html->find('div[id=content] p',0);
echo '<head><base target="_blank"><meta charset=utf-8></head>';

echo '<h3>';
echo "Wiki search for ' ".$_GET['q']."'";
echo '</h3>';
$wikisearch=str_replace('/wiki','http://en.wikipedia.org/wiki',$wikisearch);
echo $wikisearch;
echo $wikidirect->plaintext;
echo '....';
if(strlen($wikidirect)>0)
echo '<br><br> More About <strong>'.$_GET['q'].'</strong> at  <a href="'.$url.'">Wiki</a>';



?>