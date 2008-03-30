--TEST--
Services_Facebook_MarketPlace::getSubCategory()
--FILE--
<?php
require_once 'tests-config.php';
try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;

    if (count($api->marketplace->getSubCategories('FORSALE')))
    {
        echo 'Victory!';
    } else {
        echo 'Failure!';
    }
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}
?>
--EXPECT--
Victory!
