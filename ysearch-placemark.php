<head> 
<meta charset=utf-8>
<style type="text/css"> 
#map{
height: 100%;
width: 100%;
}
</style> 
<base target="_blank">
</head> 
<?php 
ini_set('user_agent','myapp/1.1');
include('web/lib/html_php_parser.php');
$key = 'dj0yJmk9QWJoRjhSNTVmNkw3JmQ9WVdrOU9HRTBUa1pyTm1zbWNHbzlNVEV5TVRreE5UQTVPQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1mYQ--';
$q=rawurlencode($_GET['q']);
$apiendpoint = 'http://wherein.yahooapis.com/v1/document';
$i=10;
$url = 'http://mycollect.in/mycollect/web/ysearch.php?query='.$q.'&type=news';
$html = file_get_html($url);
$content = $html;
$totalresult=$html->find('p strong strong',0);
//echo 'total results:'.$totalresult;
for($i=10; $i<=$totalresult; $i+=10){
$no=$i+1;
$url = 'http://mycollect.in/mycollect/web/ysearch.php?query='.$q.'&type=news&start='.$no;
$html = file_get_html($url);
$content.= $html;
}


//echo $content;
$inputType = 'text/plain';
$outputType = 'xml';
$post = 'appid='.$key.'&documentContent='.$content.
                '&documentType='.$inputType.'&outputType='.$outputType.'&autoDisambiguate=true';
$ch = curl_init($apiendpoint);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
$results = curl_exec($ch);
$places = simplexml_load_string($results, 'SimpleXMLElement', 
                                LIBXML_NOCDATA);   
$count=0;                               
                           
                                
                                 
echo '<h2>Results for News HotSpot: '.$q.'</h2>';
if($places->document->placeDetails){
foreach($places->document->placeDetails as $p){
$resultPlaceList[$count]=$p->place->name;
$resultConfidence[$count]=(int)$p->confidence;
$resultLat[$count]=$p->place->centroid->latitude;
$resultLong[$count]=$p->place->centroid->longitude;

$count++;
  
}

$resultNews[1]=$places->document->referenceList->reference->text;

//echo '<p>' .$resultNews[1]. '</p>';

$maxConf=max($resultConfidence);

//extracting the top 5 if available
$count=0;
$topCount=0;
foreach($resultPlaceList as $result){
if( $resultConfidence[$count]-$maxConf == 0 ){
	$topResultPlace[$topCount] = $resultPlaceList[$count] ;
	$topResultLat[$topCount] = $resultLat[$count] ;
	$topResultLong[$topCount] = $resultLong[$count] ;
        $topResultNews[$topCount] = $resultNews[$count];
	$topCount++;
	}
	
	$count++;
}

if($topCount <= 5) {
$final5Places = $topResultPlace ;
$final5Lat = $topResultLat ;
$final5Long = $topResultLong ;
$final5News = $topResultNews;
$finalCount = $topCount;

} else{
for($i=0; $i<5 ; $i++){
$final5Places[$i] = $topResultPlace[$i] ;
$final5Lat[$i] = $topResultLat[$i] ;
$final5Long[$i] = $topResultLong[$i] ;
$final5News[$i] = $topResultNews[$i];
}
$finalCount = 5;
}

$i=0;
foreach($final5Places as $place){
$searchtags = preg_split('/\,/',$place);
$NewsTag[$i]=$searchtags[0];
//echo 'Search tag:'.$NewsTag[$i].' News Summary: <br>';
$i=$i+1;
}

$final5MarkerCaptions;
$noofresults=0;

$remaining = $NewsTag;

foreach($content->find('div.SearchResult') as $res){ 
$summary=$res->find('div.key-value',1);
$summary1=$summary->plaintext;
$link=$res->find('a',0);
//echo $summary1;

for($i=0;$i<$finalCount; $i++){
	$isfound = stristr($summary1,$NewsTag[$i]);
	if($isfound !== false ){
	//echo $summary1.' -->'.$NewsTag[$i].'<br>';
	$final5MarkerCaptions[$i]='<b>'.$NewsTag[$i].'</b><br><i>'.htmlspecialchars($summary1)."</i><br> Source: <a href='".htmlspecialchars($link->plaintext)."'>".htmlspecialchars($link->plaintext).'</a>';
	unset($NewsTag[$i]);
	break;
	
		}
	}

}







?>
<div id="map"></div> 
<script type="text/javascript" src="http://api.maps.yahoo.com/ajaxymap?v=3.8&appid=goTpF5nV34FX7PQLFU51lI35OwT.SGpL.4F2dXdUJ2my2fj6Xwi78R6lXlWZGbSpg9_LQuiKdVMU5Q--"></script> 
<script type="text/javascript"> 
	// Create a Map that will be placed in the "map" div.
	var map = new YMap(document.getElementById('map')); 
	function startMap(){
		var totalPoint=[];
		map.drawZoomAndCenter("India");
		map.addTypeControl(); 	
		
		map.addZoomLong();    		
		
		map.addPanControl();  
		<?php
		for($i=0; $i<$finalCount; $i++){ 
		
		echo 'map.drawZoomAndCenter("'.$final5Places[$i].'");';
		echo 'var currentGeoPoint = new YGeoPoint("'.$final5Lat[$i].'","'.$final5Long[$i].'");';
		
		echo 'map.addMarker(currentGeoPoint);';
		echo 'var marker = new YMarker(currentGeoPoint);';
		echo 'marker.size = new YSize(100,40);';
		$lable=$i+1;
		echo 'marker.addLabel("'.$lable.'");';
		echo 'marker.addAutoExpand("'.$final5MarkerCaptions[$i].'");';
		echo 'map.addOverlay(marker);';
                echo 'totalPoint.push(currentGeoPoint);';
                
                
		}
		for($i=0; $i<$finalCount; $i++){ 
			$lable=$i+1;
			echo 'YLog.print("'.$lable.'->'.$final5Places[$i].'");';
 			
			}
		?>
		
             	var center = map.getBestZoomAndCenter(totalPoint);               
		map.drawZoomAndCenter(center.YGeoPoint, center.zoomLevel);
		
		
		
	}
window.onload = startMap;	
</script> 




<?php
//echo $places->documentLength;
  echo '</tbody></table>';
} else {
  echo '<h2>Couldn\'t find </h2>';
}
?>