--TEST--
Services_Facebook_Profile::getFBML()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Facebook::factory('Profile');
    $api->sessionKey = $sessionKey;
    $fbml = $api->getFBML();
    echo (string)$fbml;
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
<fb:fbml version="1.0"><fb:wide>
The PEAR module Services_Facebook is coming along nicely.
</fb:wide></fb:fbml>
