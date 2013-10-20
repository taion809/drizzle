<?php

namespace Johnsn\Drizzle;

class DrizzleTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $client = $this->getMockBuilder("Guzzle\Http\Client")
            ->setConstructorArgs(array("http://127.0.0.1:4243/{version}", array("version" => "v1.5")))
            ->getMock();

        $drizzle = new Drizzle($client);

        $this->assertInstanceOf("Johnsn\\Drizzle\\Drizzle", $drizzle);
    }

    public function testVersion()
    {
        $response_value = array(
            "Version"=> "0.6.3",
            "GitCommit" => "b0a49a3",
            "GoVersion" => "go1.1.2",
        );

        $client = $this->buildCRRStubs("/version", "get", 200, $response_value);

        $drizzle = new Drizzle($client);

        $data = $drizzle->version();

        $this->assertEquals($response_value, $data);
    }

    public function testInfoReturnsInfo()
    {
        $response_value = array(
            "Debug" => false,
            "Containers" => 3,
            "Images" => 3
        );

        $client = $this->buildCRRStubs('/info', 'get', 200, $response_value);

        $drizzle = new Drizzle($client);
        $data = $drizzle->info();

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

        $client = $this->buildCRRStubs('/containers/json', 'get', 200, $response_value);

        $drizzle = new Drizzle($client);
        $data = $drizzle->containers();

        $this->assertEquals($response_value, $data);
    }

    public function buildCRRStubs($uri, $method, $status, $result)
    {
        $response = $this->getMockBuilder("Guzzle\Http\Message\Response")
            ->setConstructorArgs(array($status))
            ->getMock();
        $response->expects($this->once())
                        ->method('json')
                        ->will($this->returnValue($result));
        
        $request = $this->getMockBuilder("Guzzle\Http\Message\Request")
            ->setConstructorArgs(array($method, $uri))
            ->getMock();
        $request->expects($this->once())
                        ->method('send')
                        ->will($this->returnValue($response));

        $client = $this->getMockBuilder("Guzzle\Http\Client")
            ->setConstructorArgs(array("http://127.0.0.1:4243/{version}", array("version" => "v1.5")))
            ->getMock();
        $client->expects($this->once())
                        ->method('createRequest')
                        ->will($this->returnValue($request));
        return $client;
    }
}