--TEST--
Services_Facebook_Photos::createAlbum()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Facebook::factory('Photos');
    $api->sessionKey = $sessionKey;

    $album = $api->createAlbum('A test album', 'San Francisco, CA', 'A test album Created by Services_Facebook');
    var_dump(((int)$album->aid > 0));
    var_dump(((string)$album->location == 'San Francisco, CA'));
    var_dump(((string)$album->description == 'A test album Created by Services_Facebook'));
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
bool(true)
bool(true)
bool(true)
