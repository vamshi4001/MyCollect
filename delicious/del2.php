<?php
function get_delicious()
{
	$cache = dirname(__FILE__) . '/caches/delicious';
	if(filemtime($cache) < (time() - 300))
	{
		@mkdir(dirname(__FILE__) . '/caches', 0777);
		$url = 'https://api.del.icio.us/v1/posts/get?tag=twitter';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		// add delicious.com username and password below
		curl_setopt($ch, CURLOPT_USERPWD, 'tungathurthi.chandu@yahoo.com:CoreJava');
		$data = curl_exec($ch);
		curl_close($ch);
		$cachefile = fopen($cache, 'wb');
		fwrite($cachefile, $data);
		fclose($cachefile);
	}
	else
	{
		$data = file_get_contents($cache);
	}
	$xml = simplexml_load_string($data);
 
	$html = '<ul>';
	foreach($xml as $item)
	{
		$html .= '<li><a href="' . $item['href'] . '">' . $item['description'] . '</a> ' . $item['extended'] . '</li>';
	}
	$html .= '<li><a href="http://delicious.com/briancray">More of Brian Cray\'s delicious bookmarks&hellip;</a></li>';
	$html .= '</ul>';
	echo $html;
}
 
// display them
get_delicious();
?>