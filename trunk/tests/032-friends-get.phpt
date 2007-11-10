--TEST--
Services_Facebook_Friends::get()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Facebook::factory('Friends');
    $api->sessionKey = $sessionKey;
    $friends = $api->get();
    foreach ($friends as $uid) {
        var_dump($uid);
    }
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
int(669245952)
