--TEST--
Services_Facebook_Profile::getFBML()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;
    $fbml = $api->profile->getFBML();
    echo (string)$fbml;
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
<fb:fbml version="1.1"><fb:wide>
The PEAR module Services_Facebook is coming along nicely.
</fb:wide></fb:fbml>
