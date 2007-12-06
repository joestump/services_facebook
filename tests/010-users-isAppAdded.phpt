--TEST--
Services_Facebook_Users::isAppAdded()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook(); // ::factory('Users');
    $api->sessionKey = $sessionKey;
    if ($api->users->isAppAdded()) {
        echo "true";
    } else {
        echo "false";
    }
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
true
