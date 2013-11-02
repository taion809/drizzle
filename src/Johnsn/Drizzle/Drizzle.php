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
        return new Providers\Container($this->client);
    }
}
