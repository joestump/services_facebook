--TEST--
Services_Facebook_Users::getLoggedInUser()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Facebook::factory('Users');
    $api->sessionKey = $sessionKey;
    var_dump(($uid == $api->getLoggedInUser()));
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
bool(true)
