--TEST--
Services_Facebook_Connect::unregisterUsers()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Facebook/Connect.php';

try {

    $emails = array(
        'mary@example.com',
        'jeff@foo.com',
        'foo@blah.com'
    );

    foreach ($emails as &$email) {
        $email = Services_Facebook_Connect::hashEmail($email);
    }

    $api    = new Services_Facebook();
    $result = $api->connect->unregisterUsers($emails);

    var_dump($result);

} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
http://api.facebook.com/restserver.php
Invalid API key
