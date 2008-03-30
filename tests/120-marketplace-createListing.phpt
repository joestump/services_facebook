--TEST--
Services_Facebook_MarketPlace::createListing()
--FILE--
<?php
require_once 'tests-config.php';
require_once 'Services/Facebook/MarketPlace/Listing.php';

try {
    $api = new Services_Facebook();
    $api->sessionKey = $sessionKey;

    $listing = new Services_Facebook_MarketPlace_Listing();
    $listing->category = 'JOBS';
    $listing->subcategory = 'SOFTWARE';
    $listing->title = 'Interns needed for hire!';
    $listing->description = 'We need interns to do labor! Apply now!  
        Free lodging in the intern dunegon.
        Its a regular cube that locks from the 
        outside and has ankle shackles and a small pale in it.';
    $listing->pay = 'oatmeal';
    $listing->full = 'true';
    $listing->intern = 'true';

    $result = $api->marketplace->createListing($listing);
    if ($result->id) {
        echo 'Victory!';
    } else {
        echo 'Failure!';
    }
} catch (Services_Facebook_Exception $e) {
    echo $e->getLastCall() . "\n";
    echo $e->getMessage();
}
?>
--EXPECT--
Victory!

