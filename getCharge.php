<?php
$xml = file_get_contents('php://input');
$xmlData = simplexml_load_string($xml);
//echo $xml;
//http://demo.mtmlive.net/webservice/api/xml/reply/GetMTCharge


$newsXML = new SimpleXMLElement($xml);
Header('Content-type: text/xml');
$xml_data = $newsXML->asXML();

$URL = "http://demo.mtmlive.net/webservice/api/xml/reply/GetMTCharge";
 
$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_MUTE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_data");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
echo $output;
curl_close($ch);