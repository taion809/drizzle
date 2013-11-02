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
        $stub = $this->getMockForAbstractClass('Johnsn\Drizzle\Providers\AbstractProvider', array($this->client));
        $stub->expects($this->any())
            ->method('setClient')
            ->will($this->returnValue(null));

        $expected = "Johnsn\\Drizzle\\Client\\GuzzleClient";
        $result = $stub->getClient();

        $this->assertInstanceOf($expected, $result);
    }

    public function testSetClient()
    {
        $stub = $this->getMockForAbstractClass('Johnsn\Drizzle\Providers\AbstractProvider', array(null));
        $stub->expects($this->any())
            ->method('setClient')
            ->will($this->returnValue(null));

        $this->assertNull($stub->setClient($this->client));

        $expected = "Johnsn\\Drizzle\\Client\\GuzzleClient";
        $result = $stub->getClient();

        $this->assertInstanceOf($expected, $result);
    }

    public function testVersion()
    {
        $response_value = array(
            'status' => 200,
            'data' => array(
                "Version"=> "0.6.4",
                "GitCommit" => "2f74b1c",
                "GoVersion" => "go1.1.2",
            ),
        );

        $client = $this->buildClient("build", $response_value);
        $stub = $this->buildStub();

        $stub->setClient($client);
        $data = $stub->version();

        $this->assertEquals($response_value, $data);
    }

    public function testInfoReturnsInfo()
    {
        $response_value = array(
            "Debug" => false,
            "Containers" => 3,
            "Images" => 3
        );

        $client = $this->buildClient("build", $response_value);
        $stub = $this->buildStub();

        $stub->setClient($client);
        $data = $stub->info();

        $this->assertEquals($response_value, $data);
    }

    public function buildStub()
    {
        $stub = $this->getMockForAbstractClass('Johnsn\Drizzle\Providers\AbstractProvider', array(null));
        $stub->expects($this->any())
            ->method('setClient')
            ->will($this->returnValue(null));

        return $stub;
    }

    public function buildClient($buildMethod, $result, $responseMethod = 'sendRequest')
    {
        $client = $this->getMockBuilder("Johnsn\\Drizzle\\Client\\GuzzleClient")
            ->getMock();

        $client->expects($this->once())
            ->method($buildMethod)
            ->will($this->returnValue($client));

        $client->expects($this->once())
            ->method($responseMethod)
            ->will($this->returnValue($result));

        return $client;
    }
}
