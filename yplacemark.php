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
$apiendpoint = 'http://wherein.yahooapis.com/v1/document';
//$url = 'http://uk.yahoo.com';
$search=urlencode("Violence in Hyderabad as KCR continues fast Calcutta News.Net Saturday 5th December, 2009 (IANS)
Telangana Rashtra Samiti (TRS) activists and students went on a rampage here Saturday, damaging shops and buses following rumours that party chief K. Chandrasekhara Rao, who is on a fast-unto-death demanding a separate Telangana state, had gone into a coma.
Hundreds of TRS workers and students from Osmania University rushed to the Nizam's Institute of Medical Sciences (NIMS) where Rao is continuing his hunger strike. Believing rumours that the condition of TRS president had turned serious, they started pelting stones on shopping malls on the busy Panjagutta-Ameerpet road in the heart of the city.
Protesters targeted big business establishments like Hyderabad Central, one of the biggest shopping malls in the city, RS Brothers, Big Bazar and also damaged two buses of the state-owned Road Transport Corporation (RTC).
The attacks in one of the commercial hubs caused panic among the people and shopkeepers downed shutters. In the Kukatpally area of the city, protesters damaged two RTC buses.
Police swung into action to disperse the protesters and prohibitory orders banning the assembly of five or more people have been imposed in the city.
As the rumours led to tension at NIMS and heavy police reinforcements were sent to tackle the situation, doctors came out to deny that the TRS leader had slipped into a coma.
NIMS director Prasada Rao told reporters that KCR, as the TRS chief is popularly known, was safe. He said KCR was shifted to the intensive care unit as a precautionary measure but he was fully conscious.
KCR, who is in judicial custody, Saturday continued the hunger strike for the fifth consecutive day.
As the movement for a separate state is receiving support from students, teachers, government employees and other sections, TRS Saturday called for a 48-hour shutdown in Telangana from midnight.
The TRS politburo, which met here, gave the shutdown call to express solidarity with KCR, who is refusing food till the central government makes a categorical statement on a separate Telangana state.
The party also demanded that a resolution for formation of separate Telangana be passed on the first day of the state assembly session on Dec 7.
Sporadic incidents of violence were reported Saturday from different parts of the region, which comprises 10 districts including Hyderabad. Police sounded an alert anticipating more violence during the two-day shutdown.
Though the state government has declared a 15-day holiday for all the colleges in the region in an attempt to keep the students away from the movement, they continued to take out rallies to support KCR's fast.
TRS workers Saturday laid siege to the houses of leaders of other political parties and legislators, urging them to back the movement. They also staged a protest outside the office of the Praja Rajyam Party (PRP) here.
PRP president Chiranjeevi visited KCR at NIMS and later told reporters that his party would back the resolution for separate state in the assembly.
Communist Party of India-Marxist (CPI-M) state secretary B. V. Raghavulu, who is opposed to bifurcation of Andhra Pradesh, had to face the ire of TRS workers when he came to NIMS to meet KCR.
Raising slogans against CPI-M leader, students tried to prevent him from entering the hospital and demanded that he first declare his support for Telangana.
With pressure mounting on them, state ministers from Telangana region wrote a letter to Congress president Sonia Gandhi appealing to her to take a clear stand on the issue.
Police arrested KCR last Sunday near Karimnagar town when he was heading to Siddipet town in Medak district for launching a fast unto death. He was taken to Khammam town, where a court sent him to jail for 14 days.
The TRS chief launched the fast in jail and was shifted to a government-run hospital in the town the next day. He, however, broke the fast the same day, saying he did not want people to lose their lives.
he angry reaction by Telangana sympathisers forced KCR to resume the fast Tuesday. He was shifted to Hyderabad early Thursday.");
$inputType = 'text/plain';
$outputType = 'xml';
$post = 'appid='.$key.'&documentType='.$inputType.'&documentContent='.$search.'&outputType='.$outputType;
$ch = curl_init($apiendpoint);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
$results = curl_exec($ch);
//echo $results;
$places = simplexml_load_string($results, 'SimpleXMLElement',LIBXML_NOCDATA);    
//echo $places;
echo '<h2>Results</h2>';
if($places->document->placeDetails){
echo '<table>';
//echo '<caption>Locations for '.$u.'</caption>';
// echo '<thead>';
// echo '<th scope="row">Name</th>';
// echo '<th scope="row">Type</th>'; 
// echo '<th scope="row">woeid</th>'; 
// echo '<th scope="row">Latitude</th>';
// echo '<th scope="row">Longitude</th>';
// echo '</thead>';
// echo '<tbody>';
?>

<div id="map"></div> 
<script type="text/javascript" src="http://api.maps.yahoo.com/ajaxymap?v=3.8&appid=goTpF5nV34FX7PQLFU51lI35OwT.SGpL.4F2dXdUJ2my2fj6Xwi78R6lXlWZGbSpg9_LQuiKdVMU5Q--"></script> 
<script type="text/javascript"> 
	// Create a Map that will be placed in the "map" div.
	var map = new YMap(document.getElementById('map')); 
	function startMap(){
	
		map.addTypeControl(); 	
		// Add the zoom control. Long specifies a Slider versus a "+" and "-" zoom control
		map.addZoomLong();    		
		// Add the Pan control to have North, South, East and West directional control
		map.addPanControl();  
		<?php
		foreach($places->document->placeDetails as $p){ 
		echo 'map.drawZoomAndCenter("'.$p->place->name.'");';
		echo 'var currentGeoPoint = new YGeoPoint("'.$p->place->centroid->latitude.'","'.$p->place->centroid->longitude.'");';
		echo 'map.addMarker(currentGeoPoint);';
		}
		?>
	}
window.onload = startMap;	
</script> 
<?php
  echo '</tbody></table>';
} else {
  echo '<h2>Couldn\'t find any locations for ';
}
?>
