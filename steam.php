<?php
define("CACHEDIR", "/tmp/");

if (is_numeric($_GET['u'])){
    $id = "profiles";
} else {
    $id = "id";
}

//http://twitter.com/statuses/user_timeline.rss?count=1
$url =  sprintf("http://steamcommunity.com/%s/%s/games?tab=all&xml=1", $id, $_GET['u']);
$cachename = "steam.".$_GET['u'].".xml";

//include("config.php");

$file = CACHEDIR.$cachename;

if (file_exists($file) && 
	(time() - filemtime($file) < 60*60*12) // Half Hour
	&& !isset($_GET['regen'])
   ){
	//die("Using Cached Content");
	$xml = file_get_contents($file);
	$xml .= sprintf("<!-- From Cache %s -->", date("r", filemtime($file)));
	$xml .= sprintf("<!-- %s -->", $url);

} else {
	//die("Getting new content");
	//die($file);
	$xml = file_get_contents($url);
	$fp = fopen($file, "w");
	fwrite($fp, $xml);
	fclose($fp);
}


//die($url);
header("Content-Type: text/xml");
echo $xml;
?>
