<?php
$xml = file_get_contents('php://input');
//echo $xml;

try {
    $new_data = new SimpleXMLElement($xml);
    Header('Content-type: text/xml');
    $new_xml_data = $new_data->asXML();
}catch (Exception $e){
    print $e->getMessage();
}

$URL = "http://demo.mtmlive.net/webservice/api/xml/reply/AddCustomer";

$ch = curl_init($URL);
curl_setopt($ch, CURLOPT_MUTE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
curl_setopt($ch, CURLOPT_USERPWD, "administrator:password");
curl_setopt($ch, CURLOPT_POSTFIELDS, "$new_xml_data");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
echo $output;
curl_close($ch);
