<?php

namespace Johnsn\Drizzle;

use Guzzle\Http\Client;

class Drizzle 
{
    protected $client = null;

    protected $endpoint = "http://127.0.0.1:4243/{version}";

    protected $options = array('version' => 'v1.5');

    private $request = null;

    public function __construct($endpoint = '', array $options = array(), $client = null)
    {
        if(!empty($endpoint)) {
            $this->endpoint = $endpoint;
        } 

        if(!empty($options)) {
            $this->options = $options;
        }

        if(!empty($client)) {
            $this->client = $client;
        } else {
            $this->client = new Client($this->endpoint, $this->options);
        }        
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;

        return true;
    }

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return true;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;

        return true;
    }

    public function request($uri, $method = 'get', array $options = array(), $body = '', array $headers = array())
    {
        $this->request = $this->client->createRequest($method, $uri, $headers, $body, $options);

        return $this;
    }

    public function response($format = 'json')
    {
        $response = $this->request->send();

        if($format == 'json') {
            return $response->json();
        }

        return $response;
    }

    public function getVersion()
    {
        $data = $this->request("/version")->response();

        return $data;
    }
}
