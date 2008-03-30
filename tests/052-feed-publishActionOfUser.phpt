--TEST--
Services_Facebook_Feed::publishActionOfUser()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;

    $title = 'went to to Vegas in July of 2007';
    $body = '<fb:userlink uid="669245952" /> went to Las Vegas in July of 2007 to celebrate <fb:userlink uid="668947253" />\'s 30th birthday!';

    $img = array(
        array('src' => 'http://bugs.joestump.net/code/Services_Facebook/img/IMG_5723.JPG',
              'href' => 'http://www.joestump.net'),
        array('src' => 'http://bugs.joestump.net/code/Services_Facebook/img/IMG_5740.JPG',
              'href' => 'http://dnevins.com')
    );

    if ($api->feed->publishActionOfUser($title, $body, $img)) {
        echo 'Victory is mine!';
    } else {
        echo 'Failure!';
    }
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
Victory is mine!
