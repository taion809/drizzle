<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 11/2/13
 * Time: 4:04 PM
 */

namespace Johnsn\Drizzle\Providers;

use Johnsn\Drizzle\Client\GuzzleClient;

class BasicTest extends \PHPUnit_Framework_TestCase
{
    protected $client = null;

    protected $container_id = '';

    public function setUp()
    {
        $c = new GuzzleClient("http://127.0.0.1", "v1.6");
        $this->client = new Basic($c);
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

        $mock = $this->buildClient("build", $response_value);
        $this->client->setClient($mock);

        $data = $this->client->version();

        $this->assertEquals($response_value, $data);
    }

    public function testInfoReturnsInfo()
    {
        $response_value = array(
            "Debug" => false,
            "Containers" => 3,
            "Images" => 3
        );

        $mock = $this->buildClient("build", $response_value);
        $this->client->setClient($mock);

        $data = $this->client->info();

        $this->assertEquals($response_value, $data);
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
