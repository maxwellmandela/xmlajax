<?php
//header('Content-type: application/xml');
//$xml =  file_get_contents("http://demo.mtmlive.net/webservice/api/xml/reply/GetExchangeRates");
//echo $xml;


function xml2Json($url) {
	$fileContents= file_get_contents($url);
	$fileContents = str_replace(array("\n", "\r", "\t", "d2p1:"), '', $fileContents);
	$fileContents = trim(str_replace('"', "'", $fileContents));
	$simpleXml = simplexml_load_string($fileContents);
	$json = json_encode($simpleXml);
	return $json;
}

echo xml2Json("http://demo.mtmlive.net/webservice/api/xml/reply/GetExchangeRates");