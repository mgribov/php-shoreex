<?php
require_once dirname(__DIR__) . '/vendor/autoload.php';

// set $api_token and $api_secret
include 'auth.php';

try {
    // we need to store HTTP response headers and responses to comply with API caching policy
    $storage_config = [
        'connection' => 'mongodb://127.0.0.1:27017',
        'database' => 'shoreex',    
        'collection' => 'api',
    ];
    
    $trip = new \ShoreEx\Client\Client($api_token, $api_secret, $storage_config, true);

    // get all cruise lines
    $cruiselines_all = $trip->getCruiseLines()->getAll();
    var_dump(__LINE__, $cruiselines_all[0]);

    // get ships for the first cruise line from above
    $ships = $trip->getCruiseLines()->get($cruiselines_all[0]['lineId']);
    var_dump(__LINE__, $ships[0]);

    // get a port list for a specific sailing
    $itin = $trip->getItinerary()->get(
        null, // no id
        [
            'shipid' => $ships[0]['shipId'], 
            'arrival' => 2016-12-31, 
            'duration' => 7,
        ]
    );
    var_dump(__LINE__, $itin);

    // get all excursions for a sailing
    //$ex = $trip->getItinerary()->getProducts($ships[0]['shipId'], new \DateTime('2016-12-31'), 7);
    $ex = $trip->getItinerary()->getProducts(2607, new \DateTime('2016-12-31'), 7);
    var_dump(__LINE__, $ex[0]);

    // get all regions
    $regions = $trip->getRegions()->getAll();
    var_dump(__LINE__, $regions[0]);

    // get all ports
    $ports = $trip->getPorts()->getAll([
        'portCode' => 'AKAC', // portCode, optional
        'regionCode' => $regions[0]['code'] // regionCode, optional
    ]);
    var_dump(__LINE__, $ports[0]);

    // get all excursions for a port
    // @todo portCode is not in a port object
    $ex = $trip->getPorts()->getProducts($ports[0]['portCode']);
    var_dump(__LINE__, $ex[0]);

    // excursion detail
    $ex1 = $trip->getProducts()->get($ex[0]['code']);
    var_dump(__LINE__, $ex1);

    // get available dates for an excursion
    $dates = $trip->getProducts()->getDates(
        $ex1['code'], 
        $ships[0]['shipId'], //optional
        new \DateTime('2016-12-31'), // arrival, optional
        7 // duration, optional
    );
    var_dump(__LINE__, $dates[0]);

    // get available times for an excursion
    $times = $trip->getProducts()->getTimes($ex1['code'], new \DateTime('2017-01-01'));
    var_dump(__LINE__, $times[0]);

} catch (\Exception $e) {
    echo "{$e->getMessage()}, {$e->getCode()}\n";
}
