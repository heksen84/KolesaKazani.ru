<?php

class SafeDOMDocument extends \DOMDocument
{
    const REGEX_JS            = '#(\s*<!--(\[if[^\n]*>)?\s*(<script.*</script>)+\s*(<!\[endif\])?-->)|(\s*<script.*</script>)#isU';
    const SUBSTITUTION_FORMAT = '<!--<script class="script_%s"></script>-->';
    private $matchedScripts = [];

    public function loadHTML($source, $options = 0)
    {
        $this->formatOutput        = false;
        $this->preserveWhiteSpace  = true;
        $this->validateOnParse     = false;
        $this->strictErrorChecking = false;
        $this->recover             = false;
        $this->resolveExternals    = false;
        $this->substituteEntities  = false;
        $matches = [];
        $success = preg_match_all(self::REGEX_JS, $source, $matches);

        if ($success && !empty($matches)) {
            foreach ($matches[0] as $match) {
                $storedScript = rtrim(ltrim($match, "\n\r\t "), "\n\r\t ");
                $scriptId = md5($storedScript);
                $key = sprintf(self::SUBSTITUTION_FORMAT, $scriptId);
                $source = str_replace($match, $key, $source);
                $this->matchedScripts[$key] = $storedScript;
            }
        }

        return parent::loadHTML($source, $options);
    }

    public function saveHTML(DOMNode $node = null)
    {
        $output = parent::saveHTML($node);

        if (count($this->matchedScripts)) {
            foreach ($this->matchedScripts as $substitution => $originalSnippet) {
                $output = str_replace($substitution, $originalSnippet, $output);
            }
        }

        return $output;
    }
}

function get_links($url) {

    // Create a new DOM Document to hold our webpage structure
    $xml = new DOMDocument();

    // Load the url's contents into the DOM
    $xml->loadHTMLFile($url);

    // Empty array to hold all links to return
    $links = array();

    //Loop through each <a> tag in the dom and add it to the link array
    foreach($xml->getElementsByTagName('a') as $link) {
        $links[] = array('url' => $link->getAttribute('href'), 'text' => $link->nodeValue);
    }

    //Return the links
    return $links;
}

$cookieJar = tempnam('/tmp', 'cookie');

$host1 = "https://salexy.kz";
$host2 = "https://shymkent.salexy.kz/catalog/info/phone/id/5746231";

// Получаем cookie
$ch = curl_init($host1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieJar);
$page = curl_exec($ch);


// {"refresh_token":"17fc86b790b70526e138334e977c27f7c53599a0","grant_type":"refresh_token","scope":"i2 read write v2","client_id":"100302","client_secret":"dHXhnUG4QDkQ3Btx07EgdZGOYydoccbtZBE5ROlNTycHxs2W"}

// Авторизованный запрос
$ch = curl_init($host2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_GET, true); 
//curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); 
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieJar);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
$page = curl_exec($ch);

echo $page;

//$xml = new DOMDocument();
//$sdd = new SafeDOMDocument();
//echo get_links("https://salexy.kz");

curl_close($ch);

?>