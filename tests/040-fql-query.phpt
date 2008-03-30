--TEST--
Services_Facebook_FQL::query()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;

    $fql = 'SELECT uid, about_me 
            FROM user 
            WHERE uid IN (' . $uid .', ' . $friendUid .')';

    $result = $api->fql->query($fql);
    foreach ($result->user as $user) {
        echo (string)$user->about_me . "\n";
    }
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
I'm a PEAR developer. This is my sandbox for working on my Facebook PEAR package.
I commute to work via bike. I don't own a car and that makes me immeasurably happy. I'm a geek in more ways than one. I consume more information in a day than was humanly possible a mere ten years ago. I'm looking forward to adding the title "World Traveler" to this section of my profile.

