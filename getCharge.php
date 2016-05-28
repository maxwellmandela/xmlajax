<?php
$xml = file_get_contents('php://input');
$xmlData = simplexml_load_string($xml);
//echo $xml;
//http://demo.mtmlive.net/webservice/api/xml/reply/GetMTCharge


$newsXML = new SimpleXMLElement($xml);
Header('Content-type: text/xml');
echo $newsXML->asXML();