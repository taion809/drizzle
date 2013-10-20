<?php

namespace Johnsn\Drizzle\Client;

class DrizzleTest extends \PHPUnit_Framework_TestCase
{
    protected $client = null;

    protected function setUp()
    {
        $this->client = new GuzzleClient("http://test.com", "v1.6");
    }

    //Maybe unnecessary?
    public function testConstructor()
    {
        $this->assertInstanceOf("Johnsn\Drizzle\Contracts\ClientInterface", $this->client);
        $this->assertInstanceOf("Guzzle\Http\Client", $this->client);
    }

    public function testBuildReturnsRequestObject()
    {
        $request = $this->client->build('info')->getRequest();

        $this->assertInstanceOf("Guzzle\Http\Message\Request", $request);
    }

    public function testBuildResponseContainsQuery()
    {
        $request = $this->client->build('info', array("t" => "123"))->getRequest();

        $this->assertEquals("t=123", $request->getQuery(true));
    }

    public function testBuildResponseProperHeaderAndUrl()
    {
        $request = $this->client->build('info')->getRequest();

        $this->assertEquals('get', strtolower($request->getMethod()));
        $this->assertEquals("http://test.com/v1.6/info", $request->getUrl());
    }

    public function testBuildJsonResponseReturnsRequestObject()
    {
        $request = $this->client->buildJson('info', array())->getRequest();

        $this->assertInstanceOf("Guzzle\Http\Message\Request", $request);
    }

    public function testBuildJsonResponseProperHeaderAndUrl()
    {
        $request = $this->client->buildJson('info', array())->getRequest();

        $this->assertEquals("application/json", $request->getHeader('Content-Type'));
        $this->assertEquals('post', strtolower($request->getMethod()));
        $this->assertEquals("http://test.com/v1.6/info", $request->getUrl());
    }

    public function testSendReturnsArray()
    {
        $json_result = array(
            "test" => "data"
        );

        $request = $this->buildRequest("info", "post", $json_result, 200, 'json');
        $this->client->setRequest($request);

        $expectedResult = array(
            "status" => 200,
            "data" => array(
                "test" => "data"
            ),
        );
        $response = $this->client->sendRequest();

        $this->assertEquals($expectedResult, $response);
    }

    public function testSendReturnsJsonString()
    {
        $raw_result = json_encode(array('test' => 'data'));

        $request = $this->buildRequest("info", "post", $raw_result, 200, 'raw');
        $this->client->setRequest($request);

        $expectedResult = array(
            "status" => 200,
            "data" => '{"test":"data"}',
        );
        $response = $this->client->sendRequest('raw');

        $this->assertEquals($expectedResult, $response);
    }

    public function buildRequest($uri, $method, $result, $status = 200, $format='json')
    {
        $response = $this->buildResponse($result, $status, $format);
        
        $request = $this->getMockBuilder("Guzzle\Http\Message\Request")
            ->setConstructorArgs(array($method, $uri))
            ->getMock();

        $request->expects($this->once())
                        ->method('send')
                        ->will($this->returnValue($response));

        return $request;
    }

    public function buildResponse($result, $status = 200, $format='json')
    {
        $response = $this->getMockBuilder("Guzzle\Http\Message\Response")
            ->setConstructorArgs(array($status))
            ->getMock();

        $response->expects($this->once())
                        ->method('getStatusCode')
                        ->will($this->returnValue($status));

        if($format == 'json') {
            $response->expects($this->once())
                        ->method('json')
                        ->will($this->returnValue($result));
        } else {
            $response->expects($this->once())
                        ->method('getBody')
                        ->will($this->returnValue($result));
        }

        return $response;
    }
}
