<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 11/2/13
 * Time: 4:09 PM
 */

namespace Johnsn\Drizzle\Providers;

class Basic extends AbstractProvider
{
    public function __construct($client)
    {
        parent::__construct($client);
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
