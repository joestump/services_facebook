--TEST--
Services_Facebook_Admin::getAppProperties()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;

	$requests = $api->admin->getAppProperties();

	var_dump($requests->dev_mode);

} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
int(1)
