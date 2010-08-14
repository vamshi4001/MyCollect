<?php
ini_set ('allow_url_fopen', '1');
ini_set('user_agent',"MyCollect/1.0");
$st_timer = microtime(true);
require './common.php';
$q = build_query();

// To cache, we save the result xml to a filename that is a
// hash of the query string.  Note the use of tempnam() and
// rename() to make sure the file is created atomically.
$cache_file = '/tmp/yws_'.md5($service[$_REQUEST['type']].$q);
if(file_exists($cache_file) && filemtime($cache_file) > (time()-7200)) {
  $raw = file_get_contents($cache_file);
} else {
  $raw = file_get_contents($service[$_REQUEST['type']].$q);
  $tmpf = tempnam('/tmp','YWS');
  file_put_contents($tmpf, $raw);
  #rename($tmpf, $cache_file);
}




$xml = simplexml_load_string($raw);
// Load up the root element attributes
foreach($xml->attributes() as $name=>$attr) $res[$name]=$attr;
echo '<head><base target="_blank"><meta charset=utf-8></head>';
$first = $res['firstResultPosition'];
$last = $first + $res['totalResultsReturned']-1;
echo "<p><strong>Showing top : $last | Total Results:<strong> ${res['totalResultsAvailable']}</strong> </strong></p>\n";
if(!empty($res['ResultSetMapUrl'])) {
  echo "<p>Result Set Map: <a href=\"${res[ResultSetMapUrl]}\">${res[ResultSetMapUrl]}</a></p>\n";
}
for($i=0; $i<$res['totalResultsReturned']; $i++) {
echo '<div class="SearchResult">';
  foreach($xml->Result[$i] as $key=>$value) {
    switch($key) {
      case 'Thumbnail':
        echo "<img src=\"{$value->Url}\" height=\"{$value->Height}\" width=\"{$value->Width}\" />\n";
        break;
      case 'Cache':
        #echo "Cache: <a href=\"{$value->Url}\">{$value->Url}</a> [{$value->Size}]<br />\n";
        break;
      case 'PublishDate':
      case 'ModificationDate':
        #echo "<b>$key:</b> ".strftime('%X %x',(int)$value)."<br />\n";
        break;
      default:
        if(stristr($key,'url')) echo "<a href=\"$value\">$value</a><br />\n";
        else echo '<div class="key-value"><b>'.$key.':</b>'. $value.'</div><br />';
        break;
    }
   
  }
  echo " </div><hr />\n";
}
next_prev($res, $first, $last);
#echo "<br /><br />Page generated in <b>".(microtime(true)-$st_timer)."</b> seconds<br />\n";
done();
?>