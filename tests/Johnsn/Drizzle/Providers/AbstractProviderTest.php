<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 11/2/13
 * Time: 3:23 PM
 */

namespace Johnsn\Drizzle\Providers;

use Johnsn\Drizzle\Client\GuzzleClient;

class AbstractProviderTest extends \PHPUnit_Framework_TestCase
{
    protected $client = null;

    public function setUp()
    {
        $this->client = new GuzzleClient("http://127.0.0.1", "v1.6");
    }

    public function testSetClientFromConstructor()
    {
        $stub = $this->buildStub($this->client);

        $expected = "Johnsn\\Drizzle\\Client\\GuzzleClient";
        $result = $stub->getClient();

        $this->assertInstanceOf($expected, $result);
    }

    public function testSetClient()
    {
        $stub = $this->buildStub();

        $this->assertNull($stub->setClient($this->client));

        $expected = "Johnsn\\Drizzle\\Client\\GuzzleClient";
        $result = $stub->getClient();

        $this->assertInstanceOf($expected, $result);
    }

    public function buildStub($client = null)
    {
        $stub = $this->getMockForAbstractClass('Johnsn\Drizzle\Providers\AbstractProvider', array($client));
        $stub->expects($this->any())
            ->method('setClient')
            ->will($this->returnValue(null));

        return $stub;
    }
}
