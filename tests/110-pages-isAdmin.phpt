--TEST--
Services_Facebook_Pages::isAdmin()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;

	$result = $api->pages->isAdmin('6111063431');
	
	var_dump($result);
	
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
bool(false)
