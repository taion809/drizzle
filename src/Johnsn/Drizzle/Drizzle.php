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

    public function containers($all=0, $limit=0, $since  = 0, $before = '', $size =1)
    {
        $uri = "/containers/json";

        $query = array(
            "all" => $all,
            "limit" => $limit,
            "since" => $since,
            "before" => $before,
            "size" => $size
        );

        $uri = $uri . "?" . http_build_query($query);

        $r = $this->request($uri);
        $data = $this->response($r);

        return $data;
    }
    
    public function version()
    {
        $r = $this->request("/version");
        $data = $this->response($r);

        return $data;
    }

    public function info()
    {
        $r = $this->request("/info");
        $data = $this->response($r);

        return $data;   
    }
}
