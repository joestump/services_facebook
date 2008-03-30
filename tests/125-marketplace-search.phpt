--TEST--
Services_Facebook_MarketPlace::search()
--FILE--
<?php
require_once 'tests-config.php';
try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;

    $l = $api->marketplace->search('San Francisco', 'JOBS', 'SOFTWARE');
    
    if (count($l)) {
        echo 'Victory!';
    } else {
        echo 'No results from search.';
    }
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}
?>
--EXPECT--
Victory!

