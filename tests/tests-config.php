<?php

$path = ini_get('include_path');
ini_set('include_path', realpath('../') . ':' . $path);

require_once 'Services/Facebook.php';
Services_Facebook::$apiKey = 'e7a775bacf1ddee36c3dd543fc0e4096';
Services_Facebook::$secret = '14b66225f517d49c20a398b340d9e381';
$sessionKey = 'a4605ff1994c3a1c43e9bf78-609143784';
$uid = 609143784;

?>
