--TEST--
Services_Facebook_Application::getPublicInfoByCanvasName()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = new Services_Facebook();

    $info = $api->application->getPublicInfoByCanvasName('services_facebook');
    
    var_dump((string)$info->app_id);
    
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}

?>
--EXPECT--
string(10) "4799760546"
