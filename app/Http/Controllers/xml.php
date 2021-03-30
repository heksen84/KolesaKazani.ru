<?php
$string = "<element><child>Hello World</child></element>";
$xml = new SimpleXMLElement($string);

// The entire XML tree as a string:
// "<element><child>Hello World</child></element>"
echo $xml->asXML();
