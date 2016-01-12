# Shore Excursions Group REST API PHP5 client  
Consumes [shoreexcursionsgroup.com](http://shoreexcursionsgroup.com) REST API by utilizing [apiscrape](https://github.com/mgribov/apiscrape)

## Install via Composer into existing project  
    curl -sS https://getcomposer.org/installer | php # if composer is not installed
    ./composer.phar require mgribov/php-shoreex

## Local Storage
Clients consuming the API are required to respect ETag and Cache-Control headers returned, and cache data locally.  
For now, only 1 storage engine is supported, MongoDB. 

## Examples
See [examples/](https://github.com/mgribov/php-shoreex/tree/master/examples) folder for all use cases  
Make sure you install composer and run "./composer.phar dump-autoload" first to use the examples
