<?php
/**
* Bing API PHP Library
* Version: 1.0
* by David González ( http://routecafe.com/ )
*
* Copyright (c) 2009 David González

* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:

* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.

*/
class BingAPI {

    private $_appID; # Application ID
    private $_queryTerms; # The input to search

    # Optional queries
    public $_version = "2.0";
    public $_market = "en-us";

    public $_sources; # The SourceType of the query

    public $_options; # An array containing optional parameters
    public $_format;  # What document will it be output into? XML, SOAP, jSON
    public $_debugQuery;
    
    private $_holder;
    protected $_curlArray;
    const BINGURL = "http://api.search.live.net/"; #URL of bing.com api
    /**
     *
     * @param <type> $appid Contains the application ID provided by bing.com
     */
    public function __construct($appid) {

        try {

            $this->_appID = $appid;

            if(empty($this->_appID)) { throw new Exception('Please insert your Application ID'); }

        } catch(Exception $e) {


            echo "An error has been detected: ".$e->getMessage();
            die(); # Stop the execution
        }

    }

    public function setSources($sources) {
        try {

            $this->_sources = $sources;

            if(empty($this->_sources)) { throw new Exception('Please insert your the Source, you may only use one in these categories: Web, Image, Spell, InstantAnswer, MobileWeb, Translation, Phonebook, Video, Ad'); }
        
        } catch(Exception $e) {
            
            echo "An error has been detected: ".$e->getMessage();
            die(); #Stop the execution
            
    }

        return $this;
    }
    /**
     * Set optional parameters, only accepts array
     * @param array $options
     * @return object
     *
     */
    public function setOptions($options) {

        $this->_options = (array) $options;
        return $this;
        
    }
    /**
     * A format is required to get the output, there are three formats currently supported: soap, xml, json
     * @param string $format
     * @return object
     */
    public function setFormat($format) {
        switch($format) {
            case 'xml':
                $this->_format = 'xml.aspx?';
            break;
            case 'json':
                $this->_format ='json.aspx?';
            break;
            case 'soap':
                #$this->_format = 'search.wsdl?';
                throw new Exception('SOAP Implementation not yet applied');
            break;
            default:
                throw new Exception('Please select a format: xml, json');
            break;
        }
        return $this;
    }
    public function setCurlArray($args) {
        $this->_curlArray = $args;
    }
    /**
     * Deprecated, use curl array
     *
     * @param string $addr
     * @deprecated
     * @return object
     */
    public function setProxy($addr) {

    throw new Exception('Deprecated');
        
    }

    /**
     * The search term which you will query the server
     * @param string $query
     * @return object
     */
    public function query($query) {
        try {

            $this->_queryTerms = $query;
            if(empty($this->_queryTerms)) { throw new Exception('We can\'t search without an input'); }
            
        } catch(Exception $e) {
            echo "An error has been detected: ".$e->getMessage();
            die();
        }

        return $this;
    }
    /**
     * This function detects and format the Highlight characters(U+E000 and U+E001 private use) bing.com provides
     * @param string $start
     * @param string $end
     * @param string $sources
     * @return string
     */
    public function setHighlightFormat($start, $end, $sources) {
              $HighlightPatterns = array(
                  $start => "/(\xEE\x80\x80)/uix",
                  $end => "/(\xEE\x80\x81)/uix");

        $Formatted = preg_replace(array_values($HighlightPatterns), array_keys($HighlightPatterns), $sources);
        return $Formatted;
    }
    /**
     * resetHighlight reverses the highlight characters, for example if you want
     * the title clear of highlight characters then this will make it possible
     * This also can be used on description if desired. or any text that contains U+E000 or U+E001
     * 
     * @param string $sources
     * @return string
     */
    public function resetHighlight($sources) {
        $HighlightPatterns = array(
                " " => "/(\xEE\x80\x80)/uix",
                "" => "/(\xEE\x80\x81)/uix");

    $Formatted = preg_replace(array_values($HighlightPatterns), array_keys($HighlightPatterns), $sources);
    return trim($Formatted);
    }

    /**
     * Returns the whole query in a string and all its parameter, useful in debugging process
     * ex. http://api.search.live.net/xml.aspx?AppId=APPID&Query=Gimp&Sources=Image
     * @return string
     */
    public function getRequestedQueryURL() {
        return $this->_debugQuery;
    }

    public function getResults() {

        try {

            if(empty($this->_format)) { throw new Exception('Please select a format: xml or json'); }

        } catch(Exception $e) {

            echo "An error has been detected: ".$e->getMessage();
            die();

        }

        $optionalParams = null;
        
        if(is_array($this->_options)) {
            
            foreach($this->_options as $query => $value) {

                $optionalParams .= '&'.$query.'='.$value;

            }

        }
    # Start curl
    $queryServer = curl_init(self::BINGURL.$this->_format."AppId=".$this->_appID."&Query=".$this->_queryTerms."&Sources=".$this->_sources.$optionalParams);
    $this->_debugQuery = self::BINGURL.$this->_format."AppId=".$this->_appID."&Query=".$this->_queryTerms."&Sources=".$this->_sources.$optionalParams;
    curl_setopt($queryServer, CURLOPT_HEADER, 0);
    curl_setopt($queryServer, CURLOPT_RETURNTRANSFER, 1);

    if(is_array($this->_curlArray)) {
    
    curl_setopt_array($queryServer, $this->_curlArray);
    }
    
    # Deliver

     $this->_holder = curl_exec($queryServer);
     return $this->_holder;
    
    # Have a great day!
    curl_close($queryServer);

    }

}
?>
