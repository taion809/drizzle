<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 11/2/13
 * Time: 3:23 PM
 */

namespace Johnsn\Drizzle\Providers;

class AbstractProviderTest extends \PHPUnit_Framework_TestCase
{
    protected $client = null;

    public function setUp()
    {
        $this->client = new \stdClass();

        $this->client->name = 'TestClient';
    }

    public function testSetClientFromConstructor()
    {
        $stub = $this->getMockForAbstractClass('Johnsn\Drizzle\Providers\AbstractProvider', array($this->client));
        $stub->expects($this->any())
            ->method('setClient')
            ->will($this->returnValue(null));

        $expected = "TestClient";
        $result = $stub->getClient();

        $this->assertEquals($expected, $result->name);
    }

    public function testSetClient()
    {
        $stub = $this->getMockForAbstractClass('Johnsn\Drizzle\Providers\AbstractProvider', array(null));
        $stub->expects($this->any())
            ->method('setClient')
            ->will($this->returnValue(null));

        $this->assertNull($stub->setClient($this->client));

        $expected = "TestClient";
        $result = $stub->getClient();

        $this->assertEquals($expected, $result->name);
    }
}
