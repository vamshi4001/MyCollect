<?php
// Yahoo Web Services PHP Example Code
// Rasmus Lerdorf
//
// This file contains the common pieces used by all the examples.
// 
$appid = 'YahooDemo';

$service = array('image'=>'http://search.yahooapis.com/ImageSearchService/V1/imageSearch',
                 'local'=>'http://local.yahooapis.com/LocalSearchService/V1/localSearch',
                 'news'=>'http://search.yahooapis.com/NewsSearchService/V1/newsSearch',
                 'video'=>'http://search.yahooapis.com/VideoSearchService/V1/videoSearch',
                 'web'=>'http://search.yahooapis.com/WebSearchService/V1/webSearch');

//header('Content-Type: text/html; charset=UTF-8');
?>
<html>
<head><title>PHP Yahoo Web Service Example Code</title><meta charset=utf-8></head>
<body>
<?php
echo "<h3>Yahoo! Image Results for '".$_GET['query']."'</h3>";
function done() {
  echo '</body></html>';
  exit;
}

function build_query() {
  global $appid, $service;
  if(empty($_REQUEST['query']) || !in_array($_REQUEST['type'],array_keys($service))) done();

  $q = '?query='.rawurlencode($_REQUEST['query']);
 # if(!empty($_REQUEST['zip'])) $q.="&zip=".$_REQUEST['zip'];
  if(!empty($_REQUEST['start'])) $q.="&start=".$_REQUEST['start'];
  $q .= "&appid=$appid";
  return $q;
}

// Create Previous/Next Page links
function next_prev($res, $start, $last) {
  if($start > 1)
    echo '<a href="'.$_SERVER['PHP_SELF'].
                   '?query='.rawurlencode($_REQUEST['query']).
                   #'&zip='.rawurlencode($_REQUEST['zip']).
                   '&type='.rawurlencode($_REQUEST['type']).
                   '&start='.($start-10).'">&lt;-Previous Page</a> &nbsp; ';
  if($last < $res['totalResultsAvailable'])
    echo '<a href="'.$_SERVER['PHP_SELF'].
                   '?query='.rawurlencode($_REQUEST['query']).
                   #'&zip='.rawurlencode($_REQUEST['zip']).
                   '&type='.rawurlencode($_REQUEST['type']).
                   '&start='.($last+1).'">Next Page-&gt;</a>';
}
?>