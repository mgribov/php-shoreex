<?php

namespace ShoreEx\Client;

use \Scrape\Client\Client as HttpClient;

/**
 * Simple wrapper to bring individual Endpoint classes, HTTP client and HTTP storage together 
 */
class Client {
    
    /**
     * HTTP client with local caching support
     * @var \Scrape\Client\Client
     */
    protected $http_client;
    
    /**
     * @var string 
     */
    public $api_url = 'http://api.shoreexcursionsgroup.com/';

    /**
     * Values to be used by HTTP client for the actual request
     * 
     * @param string $token
     * @param string $secret
     * @param array $storage_config
     * @param bool debug
     */
    public function __construct($token, $secret, array $storage_config = array(), $debug = false) {
        $config = array(
            'storage' => array(
                'class' => "\\Scrape\\Storage\\Backend\\Mongo",
                'config' => $storage_config,
                ),
            'auth' => array(
                'class' => '\\Scrape\\Auth\\HttpBasic',
                'config' => array(
                    'user' => $token,
                    'secret' => $secret
                    ),
                ),
            );
        
        $this->http_client = new HttpClient($config, $debug);
    }

    /**
     * Endpoints are defined as classes and are instantiated here
     * 
     * @param string $endpoint
     * @param array $params
     * @return \ShoreEx\Endpoint\EndpointInterface
     * @throws \Exception 
     */
    public function __call($endpoint, $params = array()) {
        $class = "\\ShoreEx\\Endpoint\\" . preg_replace('/^get/i', '', $endpoint); 
        
        if (class_exists($class)) {
            $c = new $class;
            $c->setHttpClient($this->http_client);
            $c->setPrefix($this->api_url);
            
            return $c;
        }

        throw new \Exception("Unknown endpoint $class");
    }

}
