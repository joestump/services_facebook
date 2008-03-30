--TEST--
Services_Facebook_Application::getPublicInfoById()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();

    $info = $api->application->getPublicInfoById('4799760546');
    
    var_dump((string)$info->api_key);
    
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
string(32) "e7a775bacf1ddee36c3dd543fc0e4096"
