<?php

namespace Johnsn\Drizzle;

use Guzzle\Http\Client;

class Drizzle 
{
    protected $client = null;

    public function __construct(\Guzzle\Http\Client $client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient(\Guzzle\Http\Client $client)
    {
        $this->client = $client;

        return true;
    }

    public function request($uri, $method = 'get', array $options = array(), $body = '', array $headers = array())
    {
        $request = $this->client->createRequest($method, $uri, $headers, $body, $options);

        return $request;
    }

    public function response($request, $format = 'json')
    {
        $response = $request->send();

        if($format == 'json') {
            return $response->json();
        }

        return $response;
    }

    public function getVersion()
    {
        $r = $this->request("/version");
        $data = $this->response($r);

        return $data;
    }
}
