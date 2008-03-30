--TEST--
Services_Facebook_Friends::get()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;
    $friends = $api->friends->getAppUsers();
    foreach ($friends as $uid) {
        if ($uid == $friendAppAddedUid) echo 'Success!';
    }
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
Success!
