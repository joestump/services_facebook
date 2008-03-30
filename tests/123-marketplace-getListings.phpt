--TEST--
Services_Facebook_MarketPlace::getListings()
--FILE--
<?php
require_once 'tests-config.php';
try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;

    $l = $api->marketplace->getListings($listingId, $uid);
    var_dump((string)$l->listing->listing_id);
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}
?>
--EXPECT--
string(10) "9558604374"

