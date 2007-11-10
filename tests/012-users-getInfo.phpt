--TEST--
Services_Facebook_Users::getInfo()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Facebook::factory('Users');
    $api->sessionKey = $sessionKey;
    $r = $api->getInfo($uid);
    echo (string)$r->user->about_me . "\n";
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
I'm a PEAR developer. This is my sandbox for working on my Facebook PEAR package.
