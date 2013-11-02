<?php

namespace Johnsn\Drizzle;

use Johnsn\Drizzle\Client\GuzzleClient;

class DrizzleTest extends \PHPUnit_Framework_TestCase
{
    protected $client = null;

    public function setUp()
    {
        $client = new GuzzleClient("http://test.com", "v1.2");
        $this->client = new Drizzle($client);
    }

    public function testClientInstanceOf()
    {
        $expected = 'Johnsn\Drizzle\Client\GuzzleClient';

        $this->assertInstanceOf($expected, $this->client->getClient());
    }

    public function testConnectCreatesNewClient()
    {
        $expected = 'Johnsn\Drizzle\Client\GuzzleClient';

        $client = $this->client->connect()->getClient();

        $this->assertInstanceOf($expected, $client);
    }
}
