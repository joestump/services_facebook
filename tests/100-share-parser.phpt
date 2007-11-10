--TEST--
Services_Facebook_Share::parse()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Facebook/Share.php';
require_once 'HTTP/Request.php';

$url = 'http://joestump.net/content/misc/thumbs/photobucket.html';
$req = new HTTP_Request($url);
if (PEAR::isError($req->sendRequest())) {
    die("ERROR: Could not fetch body.\n");        
}

$body = $req->getResponseBody();
$p = new Services_Facebook_Share();
$res = $p->parse($body);
print_r($res);

?>
--EXPECT--
Array
(
    [image] => Array
        (
            [src] => http://trunk.int.photobucket.com/albums/q300/efowler6/th_dog1095484-2.jpg
        )

    [video] => Array
        (
            [src] => http://www.example.com/player.swf?video_id=123456789
            [height] => 200
            [width] => 300
            [type] => application/x-shockwave-flash
        )

    [audio] => Array
        (
            [src] => http://www.example.com/player.swf?video_id=123456789
            [title] => I Don't Feel Like Dancin'
            [artist] => Scissor Sisters
            [album] => Ta-Dah
            [type] => audio/mp3
        )

    [title] => dog1095484-2.jpg picture, photo by efowler6 Photobucket
    [description] => Photobucket dog1095484-2.jpg picture, this photo was uploaded by efowler6. Browse other dog1095484-2.jpg pictures and photos or upload your own with Photobucket free image and video hosting service.
    [medium] => image
)
