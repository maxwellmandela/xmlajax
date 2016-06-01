<?php
/*$xml = file_get_contents('php://input');
$xmlData = simplexml_load_string($xml);
//echo $xml;

$newXml = new SimpleXMLElement($xml);
Header('Content-type: text/xml');
$xml_data = $newXml->asXML();
*/
$newsXML = new SimpleXMLElement("<AddCustomer xmlns:i='http://www.w3.org/2001/XMLSchema-instance' xmlns='http://schemas.datacontract.org/2004/07/MTM.DTO'></AddCustomer>");
$newsXML->addChild('ClientPassword', 'some value');
$newsXML->addChild('ClientUsername', 'Max');
$newsXML->addChild('BaseCurrency', 'some values');
$newsXML->addChild('Country', 'Maxs');
Header('Content-type: text/xml');
$xml_data = $newsXML->asXML();

$URL = "http://demo.mtmlive.net/webservice/api/xml/reply/AddCustomer";

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