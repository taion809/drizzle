<?php

namespace Johnsn\Drizzle;

class DrizzleTest extends \PHPUnit_Framework_TestCase
{
    protected $client = null;

    public function setUp()
    {
        $client = new \Johnsn\Drizzle\Client\GuzzleClient("http://test.com", "v1.2");
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

        $gclient = $this->buildClient("build", $response_value);
        $this->client->setClient($gclient);
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

        $gclient = $this->buildClient("build", $response_value);
        $this->client->setClient($gclient);
        $data = $this->client->info();

        $this->assertEquals($response_value, $data);
    }

    public function testListContainersReturnsArray()
    {
        //Subset
        $response_value = array(
            array(
                "Id" => "fd87d67dc1913289a5b3365ac7f2c1ed51e4ce7b25f3422dca99d5431e706aaa"
            ),
            array(
                "Id" => "ee684be87bcb44fa63b70de8017ebac267574053265400ec5b39442985ec72ea"
            ),
            array(
                "Id" => "b03991d1580b1f6192311ed0b31c44399aa22f03d2ed0a6468cbcffced1b16bb"
            ),
        );

        $gclient = $this->buildClient("build", $response_value);
        $this->client->setClient($gclient);
        $data = $this->client->containers(1);

        $this->assertEquals($response_value, $data);
    }

    public function buildClient($buildMethod, $result, $responseMethod = 'sendRequest')
    {
        $client = $this->getMockBuilder("Johnsn\Drizzle\Client\GuzzleClient")
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
