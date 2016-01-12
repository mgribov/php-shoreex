<?php

namespace ShoreEx\Endpoint;

/**
 * Basic structure for an endpoint 
 */
abstract class Endpoint {
    
    /**
     * Main API cluster
     * 
     * @var string
     */
    protected $prefix = 'http://api.shoreexcursionsgroup.com/';
    
    /**
     * Path after prefix, example 'destinations'
     * 
     * @var string 
     */
    protected $path;
    

    /**
     * Primary key for an object, ex: productcode
     * 
     * @var string 
     */
    protected $primaryKey;

    /**
     * 
     * @var \Scrape\Client\HttpClientInterface 
     */
    protected $http_client;

    /**
     * There is a dev version of the API which can be used sometimes
     * @param string $v 
     */
    public function setPrefix($v) {
        $this->prefix = $v;
    }
    
    /**
     * @todo path is not flexible right now
     * 
     * @param array $params 
     * @return array
     */
    public function create(array $params = array()) {
        return $this->http_client->post($this->getPath(), $params);
    }
    
    /**
     *
     * @param string $id - optional
     * @param array $params - optional
     * @param string $function - optional
     * @return array 
     */
    public function get($id = null, array $params = array(), $function = null) {
        if (!is_null($id)) {
            $params[$this->primaryKey] = $id;
        }

        $path = $this->getPath();
        
        if (!is_null($function)) {
            $path .= '/' . $function;
        }
        
        return $this->http_client->get($path, $params);
    }

    /**
     *
     * @return array 
     */
    public function getAll(array $params = array(), $func = null) {
        return $this->http_client->get($this->getPath(), $params, $func);
    }

    /**
     *
     * @param \Scrape\Client\HttpClientInterface $client 
     */
    public function setHttpClient(\Scrape\Client\Client $client) {
        $this->http_client = $client;
    }

    /**
     *
     * @return string 
     */
    public function getPath() {
        return $this->prefix . $this->path;
    }
    
}
