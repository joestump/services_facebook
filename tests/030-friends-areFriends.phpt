--TEST--
Services_Facebook_Friends::areFriends()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;
    $uid1 = array($uid, $uid);
    $uid2 = array($notFriendUid, $friendUid);
    $r = $api->friends->areFriends($uid1, $uid2);
    foreach($r->friend_info as $check) {
        var_dump((intval((string)$check->are_friends) == 1));
    }

    var_dump($api->friends->areFriends(505869088, 669245952));
    var_dump($api->friends->areFriends($notFriendUid, $uid));
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
bool(false)
bool(true)
bool(true)
bool(false)
