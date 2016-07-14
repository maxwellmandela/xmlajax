<?php
$curr = $_GET['currency'];

function xml2Json($url) {
	$fileContents= file_get_contents($url);
	$fileContents = str_replace(array("\n", "\r", "\t", "d2p1:"), '', $fileContents);
	$fileContents = trim(str_replace('"', "'", $fileContents));
	$simpleXml = simplexml_load_string($fileContents);
	$json = json_encode($simpleXml);
	return $json;
}

$json = xml2Json("http://demo.mtmlive.net/webservice/api/xml/reply/GetExchangeRates");

$exchange_rates = json_decode($json)->ExchangeRates->ExchangeRate;

foreach($exchange_rates as $exch){
	if($exch->ToCurrency == $curr){
		$rate = json_encode($exch);
		print $rate;
		break;
	}
}
