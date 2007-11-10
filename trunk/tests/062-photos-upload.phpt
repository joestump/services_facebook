--TEST--
Services_Facebook_Photos::createAlbum()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Facebook::factory('Photos');
    $api->sessionKey = $sessionKey;

    $aid = 4824;
    $caption = 'My old dining room table and chairs in Seattle, WA';
    $photo = $api->upload(realpath('test-image.jpg'), $aid, $caption);
    var_dump(($photo->caption == $caption)); 
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
bool(true)
