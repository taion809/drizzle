<?php

namespace Johnsn\Drizzle;

use Guzzle\Http\Client;

class Drizzle 
{
    protected $client = null;

    public function __construct($client = null)
    {
        if(!empty($client)) {
            $this->client = $client;
        }
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function connect($endpoint = 'http://127.0.0.1:4243', $version = 'v1.6')
    {
        $this->client = new \Johnsn\Drizzle\Client\GuzzleClient($endpoint, $version);
        return $this;
    }

    public function getContainerProvider()
    {
        return new Providers\Container($this->client, '');
    }

    public function containers($all=0, $limit=-1, $since  = '', $before = '', $size =1)
    {
        $uri = "containers/json";

        $query = array(
            "all" => $all,
            "limit" => $limit,
            "since" => $since,
            "before" => $before,
            "size" => $size
        );

        $data = $this->client->build($uri, $query)->sendRequest();

        return $data;
    }
    
    public function version()
    {
        $data = $this->client->build("version")->sendRequest();

        return $data;
    }

    public function info()
    {
        $data = $this->client->build("info")->sendRequest();

        return $data;   
    }
}
