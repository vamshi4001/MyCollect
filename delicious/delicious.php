<?php
require('php-delicious.inc.php');
define('DELICIOUS_USER', 'tckb');
define('DELICIOUS_PASS', 'CoreJava');
$oDelicious = new PhpDelicious(DELICIOUS_USER, DELICIOUS_PASS);
$sTag = 'yahoo'; 

// if ($aPosts = $oDelicious->GetAllPosts()) {
    // foreach ($aPosts as $aPost) {
        // echo '<a href="'.$aPost['url'].'">'.$aPost['desc'].'</a>';
        // echo $aPost['notes'];
        // echo $aPost['updated'];
    // }
// } else {
    // echo $oDelicious->LastErrorString();
// }

// if ($aPosts = $oDelicious->GetPosts($sTag)) {
    // foreach ($aPosts as $aPost) {
        // echo '<a href="'.$aPost['url'].'">'.$aPost['desc'].'</a>';
        // echo $aPost['notes'];
        // echo $aPost['updated'];
    // }
// } else {
    // echo $oDelicious->LastErrorString();
// }
// $sTag = 'twitter', // filter by tag
// $iCount = 15 // number of posts to retrieve, min 15, max 100
// if ($aPosts = $oDelicious->GetRecentPosts($sTag,$iCount)) {
    // foreach ($aPosts as $aPost) {
        // echo '<a href="'.$aPost['url'].'">'.$aPost['desc'].'</a>';
        // echo $aPost['notes'];
        // echo $aPost['updated'];
    // }
// } else {
    // echo $oDelicious->LastErrorString();
// }

$aPost = array();
$aPost['url'] = 'http://www.yahoo.com';
$aPost['description'] = 'Yahoo! home page';
$aPost['notes'] = 'Lame search engine'; 
$aPost['updated'] = date('Y-m-d H:i:s'); //mysql timestamp
$aTags = array('lame','dumb','search engine'); //must be array
$oDelicious->AddPost($aPost['url'], $aPost['description'], $aPost['notes'], $aTags, $aPost['updated'], true);
?>
