--TEST--
Services_Facebook_Feed::publishStoryToUser()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Facebook::factory('Feed');
    $api->sessionKey = $sessionKey;

    $title = '<a href="http://www.joestump.net">Joe Stump</a> went to to Vegas in July of 2007';
    $body = '<b>Joe Stump</b> went to Las Vegas in July of 2007 to celebrate <a href="http://dnevins.com">Dana Nevins</a>\'s 30th birthday!';

    $img = array(
        array('src' => 'http://bugs.joestump.net/code/Services_Facebook/img/IMG_5723.JPG',
              'href' => 'http://www.joestump.net'),
        array('src' => 'http://bugs.joestump.net/code/Services_Facebook/img/IMG_5740.JPG',
              'href' => 'http://dnevins.com')
    );

    if ($api->publishStoryToUser($title, $body, $img)) {
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
I'm a PEAR developer. This is my sandbox for working on my Facebook PEAR package.
I commute to work via bike. I don't own a car and that makes me immeasurably happy. I'm a geek in more ways than one. I consume more information in a day than was humanly possible a mere ten years ago. I'm looking forward to adding the title "World Traveler" to this section of my profile.

