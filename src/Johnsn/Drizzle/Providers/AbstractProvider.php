<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 11/2/13
 * Time: 12:02 PM
 */

namespace Johnsn\Drizzle\Providers;

abstract class AbstractProvider
{
    protected $client = null;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function getClient()
    {
        return $this->client;
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
