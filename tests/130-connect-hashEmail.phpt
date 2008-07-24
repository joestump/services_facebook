--TEST--
Services_Facebook_Connect::hashEmail()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Facebook/Connect.php';

try {

    $email = 'mary@example.com';
    $hash  = Services_Facebook_Connect::hashEmail($email);

    var_dump($hash);

} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
string(43) "4228600737_c96da02bba97aedfd26136e980ae3761"
