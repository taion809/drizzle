<?php

namespace Johnsn\Drizzle;

class DrizzleTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $drizzle = new Drizzle();
        $endpoint = $drizzle->getEndpoint();

        $this->assertInstanceOf("Johnsn\\Drizzle\\Drizzle", $drizzle);
        $this->assertEquals($endpoint, "http://127.0.0.1:4243/{version}");
    }

    public function testVersion()
    {
        $response_value = array(
            "Version"=> "0.6.3",
            "GitCommit" => "b0a49a3",
            "GoVersion" => "go1.1.2",
        );

        $client = $this->buildCRRStubs("/version", "get", 200, $response_value);

        $drizzle = new Drizzle('', array(), $client);

        $data = $drizzle->getVersion();

        $this->assertNotEmpty($data);
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