--TEST--
Services_Facebook_MarketPlace::removeListing()
--FILE--
<?php
require_once 'tests-config.php';
try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;

    var_dump($api->marketplace->removeListing($successListingId));
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}
--EXPECT--
bool(true)

