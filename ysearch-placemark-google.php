<head> 
<meta charset=utf-8>
<style type="text/css"> 
#map{
height: 75%;
width: 100%;
}
</style> 
</head> 
<?php 
ini_set('user_agent','myapp/1.1');
include('web/lib/html_php_parser.php');
$key = 'dj0yJmk9QWJoRjhSNTVmNkw3JmQ9WVdrOU9HRTBUa1pyTm1zbWNHbzlNVEV5TVRreE5UQTVPQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD1mYQ--';
$q=rawurlencode($_GET['q']);
$apiendpoint = 'http://wherein.yahooapis.com/v1/document';
$i=10;
$url = 'http://projects.tckb.x10hosting.com/mycollect/web/ysearch.php?query='.$q.'&type=news';
$html = file_get_html($url);
$content = $html->plaintext;
$totalresult=$html->find('p strong strong',0);
echo 'total results:'.$totalresult;
for($i=10; $i<=$totalresult; $i+=10){
$no=$i+1;
$url = 'http://projects.tckb.x10hosting.com/mycollect/web/ysearch.php?query='.$q.'&type=news&start='.$no;
$html = file_get_html($url);
$content.= $html->plaintext;
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
                           
                                
                                 
echo '<h2>Results</h2>';
if($places->document->placeDetails){
echo '<table>';
echo '<thead>';
echo '<th scope="row">Name</th>';
echo '<th scope="row">Type</th>'; 
echo '<th scope="row">woeid</th>'; 
echo '<th scope="row">Latitude</th>';
echo '<th scope="row">Longitude</th>';
echo '<th scope="row">Weight</th>';
echo '<th scope="row">Confidence</th>';
echo '</thead>';
echo '<tbody>';
foreach($places->document->placeDetails as $p){
$resultPlaceList[$count]=$p->place->name;
$resultConfidence[$count]=(int)$p->confidence;
$resultLat[$count]=$p->place->centroid->latitude;
$resultLong[$count]=$p->place->centroid->longitude;
$count++;
  echo '<tr>';
  echo '<td>'.$p->place->name.'</td>';
  echo '<td>'.$p->place->type.'</td>';
  echo '<td>'.$p->place->woeId.'</td>';
  echo '<td>'.$p->place->centroid->latitude.'</td>';
  echo '<td>'.$p->place->centroid->longitude.'</td>';
 echo '<td>'.$p->weight.'</td>';
 echo '<td>'.$p->confidence.'</td>';
 echo '</tr>';
}
$maxConf=max($resultConfidence);

//extracting the top 5 if available
$count=0;
$topCount=0;
foreach($resultPlaceList as $result){
if( $resultConfidence[$count]-$maxConf == 0 ){
	$topResultPlace[$topCount] = $resultPlaceList[$count] ;
	$topResultLat[$topCount] = $resultLat[$count] ;
	$topResultLong[$topCount] = $resultLong[$count] ;
	$topCount++;
	}
	
	$count++;
}

echo ' Selected top results are:-';

if($topCount <= 5) {
$final5Places = $topResultPlace ;
$final5Lat = $topResultLat;
$final5Long = $topResultLong ;
$finalCount = $topCount;

} else{
for($i=0; $i<5 ; $i++){
$final5Places[$i] = $topResultPlace[$i] ;
$final5Lat[$i] = $topResultLat[$i] ;
$final5Long[$i] = $topResultLong[$i] ;
$finalCount = 5;

}
}
?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAHc_zYr3FNE9U361gi5JAjxSeFdbnqGZRzX7G3bDWEsNn7uMw0RTtQyUi5CjigXUWHxvF0dRw-KVoJg"
            type="text/javascript"></script>
    <script type="text/javascript">
    
    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        
       <?php
		for($i=0; $i<$finalCount; $i++){
		        	  
		echo 'map.setCenter(new GLatLng('.$final5Lat[$i].','.$final5Long[$i].');';
		echo 'var point = new GLatLng('.$final5Lat[$i].','.$final5Long[$i].');';	
		echo 'map.addOverlay(new GMarker(point));';
		}
		
		?>
         
        
      }
    }

    </script>
  </head>

  <body onload="initialize()" onunload="GUnload()">
    <div id="map_canvas" style="width: 500px; height: 300px"></div>
  </body>





<?php
//echo $places->documentLength;
  echo '</tbody></table>';
} else {
  echo '<h2>Couldn\'t find </h2>';
}
?>