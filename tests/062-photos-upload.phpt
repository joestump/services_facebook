--TEST--
Services_Facebook_Photos::createAlbum()
--SKIPIF--
<?php
if (!extension_loaded('exif')) echo 'skip exif extension not available';
?>
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook('Photos');
    $api->sessionKey = $sessionKey;

    $aid = 2000173;
    $caption = 'My old dining room table and chairs in Seattle, WA';
    $photo = $api->photos->upload(realpath('test-image.jpg'), $aid, $caption);
    var_dump(($photo->caption == $caption)); 
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
bool(true)
