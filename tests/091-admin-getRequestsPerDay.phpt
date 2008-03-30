--TEST--
Services_Facebook_Admin::getRequestsPerDay()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;
    $requests = $api->admin->getRequestsPerDay();
    
    var_dump($requests);
    
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
int(12)
