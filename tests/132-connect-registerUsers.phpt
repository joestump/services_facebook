--TEST--
Services_Facebook_Connect::registerUsers()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Facebook/Connect.php';

try {

    $accounts   = array();
    $accounts[] = array(
        'email_hash'  => Services_Facebook_Connect::hashEmail('foo@bar.com'),
        'account_id'  => 42,
        'account_url' => 'http://example.com/foo'
    );

    $accounts[] = array(
        'email_hash' => Services_Facebook_Connect::hashEmail('blah@foo.com'),
    );

    $api    = new Services_Facebook();
    $result = $api->connect->unregisterUsers($accounts);

    var_dump($result);

} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
http://api.facebook.com/restserver.php
Invalid API key
