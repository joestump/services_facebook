--TEST--
Services_Facebook_MarketPlace::getCategories()
--FILE--
<?php
require_once 'tests-config.php';
try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;
    
    if (count($api->marketplace->getCategories())) {
        echo 'Victory!';
    } else {
        echo 'Failure, recieved no categories.';
    }
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}
--EXPECT--
Victory!

