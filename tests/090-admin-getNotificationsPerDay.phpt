--TEST--
Services_Facebook_Admin::getNotificationsPerDay()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;
	$notifications = $api->admin->getNotificationsPerDay();
	
	if ($notifications) echo "Victory!";
	
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
Victory!
