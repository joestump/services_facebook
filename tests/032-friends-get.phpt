--TEST--
Services_Facebook_Friends::get()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;
    $friends = $api->friends->get();
    foreach ($friends as $uid) {
        if (!in_array($uid, $friends)) echo 'Failure!';
    }
    echo 'We\'re doing okay.';
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
We're doing okay.
