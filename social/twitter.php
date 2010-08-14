<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Twitter Search </title>
<link href="style.css" rel="stylesheet" type="text/css" />
<style>

.twitter_thumb{
float:left;
margin-right:20px;
margin-bottom:0px;
}


body{
font-family:Verdana, Geneva, sans-serif;
font-size:14px;}

.user{
background-color:#efefef;
margin-bottom:10px;
border-bottom:;
padding:10px;}


.clear{
clear:both;
}

#search{
padding:8px;
background-color:#CCFFFF;
}


</style>

</head>

<body>


<?php

// Date function (this could be included in a seperate script to keep it clean)
include('date.php');
ini_set ('allow_url_fopen', '1');
ini_set('user_agent',"MyCollect/1.0");


// Work out the Date plus 8 hours
// get the current timestamp into an array
$timestamp = time();
$date_time_array = getdate($timestamp);

$hours = $date_time_array['hours'];
$minutes = $date_time_array['minutes'];
$seconds = $date_time_array['seconds'];
$month = $date_time_array['mon'];
$day = $date_time_array['mday'];
$year = $date_time_array['year'];

// use mktime to recreate the unix timestamp
// adding 19 hours to $hours
$timestamp = mktime($hours + 0,$minutes,$seconds,$month,$day,$year);
$theDate = strftime('%Y-%m-%d %H:%M:%S',$timestamp);	



// END DATE FUNCTION




//Search API Script

$q=$_GET['q'];

if($_GET['q']==''){

$q = 'yahoo hack u ';}

$search = "http://search.twitter.com/search.atom?q=".rawurlencode($q);

$tw = curl_init();

curl_setopt($tw, CURLOPT_URL, $search);
curl_setopt($tw, CURLOPT_RETURNTRANSFER, TRUE);
$twi = curl_exec($tw);
$search_res = new SimpleXMLElement($twi);

echo '<head><base target="_blank"></head>';	
echo "<h3>What people are taking abt...'".$q."'</h3>";

## Echo the Search Data

foreach ($search_res->entry as $twit1) {

$description = $twit1->content;

$description = preg_replace("#(^|[\n ])@([^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://www.twitter.com/\\2\" >@\\2</a>'", $description);  
$description = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t<]*)#ise", "'\\1<a href=\"\\2\" >\\2</a>'", $description);
$description = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r<]*)#ise", "'\\1<a href=\"http://\\2\" >\\2</a>'", $description);

$retweet = strip_tags($description);


$date =  strtotime($twit1->updated);
$dayMonth = date('d M', $date);
$year = date('y', $date);
#$message = $row['content'];
$datediffr = date_diffi($theDate, $date);



echo "<div class='user'><a href=\"",$twit1->author->uri,"\" target=\"_blank\"><img border=\"0\" width=\"48\" class=\"twitter_thumb\" src=\"",$twit1->link[1]->attributes()->href,"\" title=\"", $twit1->author->name, "\" /></a>\n";
echo "<div class='text'>".$description."<div class='description'>From: ", $twit1->author->name," <a href='http://twitter.com/home?status=RT: ".$retweet."' target='_blank'>Retweet!</a></div><strong>".$datediffr."</strong></div><div class='clear'></div></div>";

}


curl_close($tw);

?>
</body>
</html>