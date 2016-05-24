<?php
/**
 * Created by PhpStorm.
 * User: mxmandela
 * Date: 5/23/16
 * Time: 6:14 PM
 */
//working
//$xml = file_get_contents('php://input');
//$xmlData = simplexml_load_string($xml);
//echo $xml;//Data->Book->Title;

/*$newsXML = new SimpleXMLElement("<news></news>");
$newsXML->addAttribute('newsPagePrefix', 'value goes here');
$newsIntro = $newsXML->addChild('content', 'some value');
$newsIntro = $newsXML->addChild('by', 'Max');
$newsIntro = $newsXML->addChild('contents', 'some values');
$newsIntro = $newsXML->addChild('bys', 'Maxs');
$newsIntro->addAttribute('type', 'latest');
Header('Content-type: text/xml');
echo $newsXML->asXML();*/

$sxe = new SimpleXMLElement("<movies></movies>");
$sxe->addAttribute('type', 'documentary');

$movie = $sxe->addChild('movie');
$movie->addChild('title', 'PHP2: More Parser Stories');
$movie->addChild('plot', 'This is all about the people who make it work.');

$characters = $movie->addChild('characters');
$character  = $characters->addChild('character');
$character->addChild('name', 'Mr. Parser');
$character->addChild('actor', 'John Doe');

$rating = $movie->addChild('rating', '5');
$rating->addAttribute('type', 'stars');
Header('Content-type: text/xml');
echo $sxe->asXML();
