<?php

ini_set('memory_limit','128M');
ini_set('user_agent','MyCollect/1.0');
error_reporting(~E_NOTICE);
// Include the Bing API PHP Library
require 'lib/BingAPI.php';



// Simply start the class with your AppID argumented
$search = new BingAPI('A92BF656473E4356E0594FECD2819614D502461E');

// Taken out of php.net
function stripslashes_deep($value)
{
    $value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);

    return $value;
}

$_GET = array_map('stripslashes_deep',$_GET);

if(isset($_GET['searchTerm']) && !empty($_GET['searchTerm'])) {


    // Build your query easily
    $searchWeb = (isset($_GET['searchTerm'])) ? stripslashes(urlencode($_GET['searchTerm'])) : '';
    // TODO: MAKE THE SWITCH CASE FOR SOURCES TYPE
  
    switch($_GET['SourceType']) {

        case 'Images':
            $appendSource = 'Image';
            $optionSource = array(
                            'Image.Count' => '50',
                            'Image.Offset' => '0',
                            'Image.Filters' => 'Size:Large',
                            'Options' => 'EnableHighlighting');
        break;

        case 'Web':
            $appendSource = 'Web';
            $optionSource = array(
                            'Web.Count' => '50',
                            'Web.Offset' => '20',
                            'Adult' => 'Moderate',
                            'Options' => 'EnableHighlighting');
        break;

        case 'News':
            $appendSource = 'News';
            $optionSource = array(
                            'News.Offset' => '0',
                            'News.SortBy' => 'Relevance');
        break;
        
        default:
            $appendSource = 'Web';
            $optionSource = array(
                           'Web.Count' => '50',
                           'Web.Offset' => '0',
                           'Adult' => 'Moderate',
                           'Options' => 'EnableHighlighting');
        break;
    }

    // Gotta love switches..
    
    $search->query($searchWeb)
           ->setSources($appendSource) # To use multiple resources simply do ->setSources('Web+Image') , it must match the source type bling.com provides
           ->setFormat('xml')
           ->setOptions($optionSource);

    // Contains the search
    $results = $search->getResults();

    // Start our SimpleXML class
    $xml = new SimpleXMLElement($results);


    // Every structure of bing.com is pratically similar, so its safe to say you can use this assign
    $QueriedTerm = $xml->Query->SearchTerms;


    /**
     * Getting the sources from WEB
     */
    $WebResultSet = $xml->children('http://schemas.microsoft.com/LiveSearch/2008/04/XML/web');
    // Demonstration on how to count the results
    $TotalWebResults = (isset($_GET['SourceType']) == 'Web' || empty($_GET['SourceType'])) ? count($WebResultSet->Web->Results->WebResult) : '';


    /**
     * Getting the sources from Image
     */
    $ImageResultSet =  $xml->children('http://schemas.microsoft.com/LiveSearch/2008/04/XML/multimedia');
    $TotalImageResults = (isset($_GET['SourceType']) && $_GET['SourceType'] == 'Images') ? count($ImageResultSet->Image->Results->ImageResult) : '';
    
    /**
     * Getting the sources from News
     */
    $NewsResultSet =  $xml->children('http://schemas.microsoft.com/LiveSearch/2008/04/XML/news');
    $TotalNewsResults = (isset($_GET['SourceType']) && $_GET['SourceType'] == 'News') ? count($NewsResultSet->News->Results->NewsResult) : '';
}


/* Appends and encode the search term to allow easier search using the links */
$appendSearch = (isset($_GET['searchTerm'])) ? '&amp;searchTerm='.stripslashes(urlencode($_GET['searchTerm'])) : '';

/* For the form action
 *
 */
    $formValue = (isset($_GET['searchTerm'])) ? htmlspecialchars($_GET['searchTerm'], ENT_QUOTES) : '';
    $formAction = (isset($_GET['SourceType'])) ? htmlspecialchars($_GET['SourceType']) : 'Web';
?>
<html>
<?php
echo '<head><base target="_blank"><meta charset=utf-8></head>';
echo " <h3>Bing! search results for '".$_GET['searchTerm']."'</h3>";


// Yet another switch, but hey they are pretty useful! better than building an if/else empire
switch($_GET['SourceType']) {
    case 'Web':
        
        $inTotal = $WebResultSet->Web->Total;
        if(isset($_GET['searchTerm']) && !empty($_GET['searchTerm'])) {
        
	  // echo $DisplayNum;
	 //   $DisplayNum =  (isset($_GET['searchTerm'])) ? ' 
echo '<strong>Showing top : </strong> ' . $TotalWebResults ;
    echo " | <strong>Total Results : </strong> ";
    echo number_format(floatval($inTotal));
    
    }
    
         break;
    case 'Images':
        
        $inTotal = $ImageResultSet->Image->Total;
        if(isset($_GET['searchTerm']) && !empty($_GET['searchTerm'])) {
    echo $DisplayNum;
    echo " <strong>Total Results : </strong> ";
    echo number_format(floatval($inTotal));
    
    }
    $DisplayNum =  (isset($_GET['searchTerm'])) ? ' | <strong>Showing top :</strong>' . $TotalImageResults : '';
    break;
    case 'News':
        
         $inTotal = $NewsResultSet->News->Total;
         if(isset($_GET['searchTerm']) && !empty($_GET['searchTerm'])) {
    echo $DisplayNum;
    echo " <strong>Total Results : </strong> ";
    echo number_format(floatval($inTotal));
    
    }
    $DisplayNum = (isset($_GET['searchTerm'])) ? ' | <strong>Showing top :</strong>' . $TotalNewsResults : '';
    break;
}




?>
<div class="results">
    <?php
    // The Web
    if(isset($_GET['searchTerm']) && $_GET['SourceType'] == 'Web' || empty($_GET['SourceType'])) {
    $i = 0;
    echo "<ol>";
    while($TotalWebResults >= $i) {
        // Force the while to stop
        if($TotalWebResults == $i) {
            break; // It something that happened to me while I was doing this
            /* Somehow, while we enter the loop, either live api hangs in the connection
             * therefore, we'll force it out of the loop or it will continue even knowing its finished
             */
        }

        // This is double checking we don't step on a landmine while searching, along with the <sub>break;</sub> 
        if(is_object($WebResultSet->Web->Results->WebResult[$i])) {
        // Re-assures us that the object is really an object;
        
        /* BING gives you a raw title and description, run a htmlspecialchars to convert special characters */
        $Title = htmlentities($WebResultSet->Web->Results->WebResult[$i]->Title, ENT_QUOTES, 'UTF-8', true);
        // I don't want my titles with characters
        $Title = $search->resetHighlight($Title);
        $Description =  $WebResultSet->Web->Results->WebResult[$i]->Description;

       
        $Description = $search->setHighlightFormat(
                                "<span class='hl'>",
                                "</span>",
                                $WebResultSet->Web->Results->WebResult[$i]->Description
                            );



        if(!empty($Title)) {
        echo "<li><div class='result'>".PHP_EOL;
        echo "\t\t<div class='title'><a href='{$WebResultSet->Web->Results->WebResult[$i]->Url}'".
             " title='{$Title}'>".$Title."</a></h4>".PHP_EOL;
        echo "\t\t<div class='desc'>{$Description}</div>".PHP_EOL;
        echo "</div></li>".PHP_EOL;
        $i++;

        }
        }
    }
    echo "</ol>";
    }

    // The Images
    if(isset($_GET['searchTerm']) && $_GET['SourceType'] == 'Images') {
    $i = 0;
  
    while($TotalImageResults >= $i) {
        if($TotalImageResults == $i) {
            break; // It something that happened to me while I was doing this
            /* Somehow, while we enter the loop, either live api hangs in the connection
             * therefore, we'll force it out of the loop or it will continue even knowing its finished
             */
        }
        $ThumbURL = $ImageResultSet->Image->Results->ImageResult[$i]->Thumbnail[0]->Url;
        $ThumbWidth = $ImageResultSet->Image->Results->ImageResult[$i]->Thumbnail[0]->Width;
        $ThumbHeight = $ImageResultSet->Image->Results->ImageResult[$i]->Thumbnail[0]->Height;
        $ThumbSite = $ImageResultSet->Image->Results->ImageResult[$i]->Url;
        $MediaUrl = $ImageResultSet->Image->Results->ImageResult[$i]->MediaUrl;
        // Force the while to stop
        if($i % 5 == 0) {
            echo "<div class='resultblock'>".PHP_EOL;
        }
        echo "\t<div class='resultimg'>".PHP_EOL;
        echo "\t\t<a href='$MediaUrl'><img src='{$ThumbURL}' width='$ThumbWidth' height='$ThumbHeight' /></a>".PHP_EOL;
        echo "<div class='sources'><a href='$ThumbSite'>Main Sources</a></div>";
        echo "\t</div>".PHP_EOL;
        $i++;
        if($i % 5 == 0) {
            echo "</div> <div class='clear'></div>";
        }
    }
    }

    if(isset($_GET['searchTerm']) && $_GET['SourceType'] == 'News') {
    $i = 0;
    while($TotalNewsResults >= $i) {
        if($TotalNewsResults == $i) {
            break; 
        }
        $Title = htmlspecialchars($NewsResultSet->News->Results->NewsResult[$i]->Title, ENT_QUOTES);
        $Snippet = htmlspecialchars($NewsResultSet->News->Results->NewsResult[$i]->Snippet, ENT_QUOTES);
        $Sources = htmlspecialchars($NewsResultSet->News->Results->NewsResult[$i]->Source, ENT_QUOTES);
        $NewsURL = htmlspecialchars($NewsResultSet->News->Results->NewsResult[$i]->Url, ENT_QUOTES);
        echo "<div class='newsresult'>".PHP_EOL;
        echo "\t\t<div class='title'><a href='$NewsURL' title='$Title'>$Title</a></div>".PHP_EOL;
        echo "\t\t<div class'desc'>$Snippet</div>".PHP_EOL;
        echo "\t\t<div class='cite'>Sources from: $Sources  </div>".PHP_EOL;
        echo "</div>".PHP_EOL;
    $i++;
    
    }
    }


    ?>
</div>
</body>
</html>