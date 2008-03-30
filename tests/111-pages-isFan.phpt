--TEST--
Services_Facebook_Pages::isFan()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();
	$api->sessionKey = $sessionKey;
	
	$result = $api->pages->isFan($fanOfUid, $uid);
	
	var_dump($result);
	
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
bool(true)
