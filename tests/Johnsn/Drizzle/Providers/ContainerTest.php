<?php
/**
 * Created by PhpStorm.
 * User: nick
 * Date: 11/2/13
 * Time: 2:19 PM
 */

namespace Johnsn\Drizzle\Providers;

use Johnsn\Drizzle\Client\GuzzleClient;

class ContainerTest extends \PHPUnit_Framework_TestCase
{
    protected $client = null;

    protected $container_id = '';

    public function setUp()
    {
        $c = new GuzzleClient("http://127.0.0.1", "v1.6");
        $this->client = new Container($c);

        $this->container_id = 'b74feff85fd21e559ad6dbc49f46f36849d54c9fa8710b3536eb4ad27e2ae46c';
    }

    public function testContainerList()
    {
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

    public function testInspectReturnsArray()
    {
        $response_value = array(
            'status' => 200,
            'data' => array(
                'ID' => 'b74feff85fd21e559ad6dbc49f46f36849d54c9fa8710b3536eb4ad27e2ae46c',
            ),
        );

        $gclient = $this->buildClient("build", $response_value);
        $this->client->setClient($gclient);
        $data = $this->client->inspect($this->container_id);

        $this->assertEquals($response_value, $data);
    }

    public function testTopReturnsArray()
    {
        $response_value = array(
            'status' => 200,
            'data' => array(
                "Titles" => array(
                    "PID", "TTY", "STAT", "TIME", "COMMAND"
                ),
                "Processes" => null,
            ),
        );

        $gclient = $this->buildClient("build", $response_value);
        $this->client->setClient($gclient);
        $data = $this->client->top($this->container_id);

        $this->assertEquals($response_value, $data);
    }

    public function testTopPsArgsReturnsArray()
    {
        $response_value = array(
            'status' => 200,
            'data' => array(
                "Titles" => array(
                    "USER", "PID", "%CPU", "%MEM", "VSZ", "RSS", "TTY", "STAT", "TIME", "COMMAND"
                ),
                "Processes" => null,
            ),
        );

        $gclient = $this->buildClient("build", $response_value);
        $this->client->setClient($gclient);
        $data = $this->client->top($this->container_id, "aux");

        $this->assertEquals($response_value, $data);
    }

    public function testChangesReturnsArray()
    {
        $response_value = array(
            'status' => 200,
            'data' => array(),
        );

        $gclient = $this->buildClient("build", $response_value);
        $this->client->setClient($gclient);
        $data = $this->client->changes($this->container_id);

        $this->assertEquals($response_value, $data);
    }

    public function testExportReturnsNotImplementedString()
    {
        $expected = "Not yet implemented";

        $data = $this->client->export($this->container_id);

        $this->assertEquals($expected, $data);
    }

    public function testStartContainerReturnsEmptyString()
    {
        $expected = "";

        $gclient = $this->buildClient("buildJson", $expected);
        $this->client->setClient($gclient);
        $data = $this->client->start($this->container_id);

        $this->assertEquals($expected, $data);
    }

    public function testStopContainerReturnsEmptyString()
    {
        $expected = "";

        $gclient = $this->buildClient("buildJson", $expected);
        $this->client->setClient($gclient);
        $data = $this->client->stop($this->container_id);

        $this->assertEquals($expected, $data);
    }

    public function testRestartContainerReturnsEmptyString()
    {
        $expected = "";

        $gclient = $this->buildClient("buildJson", $expected);
        $this->client->setClient($gclient);
        $data = $this->client->restart($this->container_id);

        $this->assertEquals($expected, $data);
    }

    public function testKillContainerReturnsEmptyString()
    {
        $expected = "";

        $gclient = $this->buildClient("buildJson", $expected);
        $this->client->setClient($gclient);
        $data = $this->client->kill($this->container_id);

        $this->assertEquals($expected, $data);
    }

    public function testAttachReturnsNotImplementedString()
    {
        $expected = "Not yet implemented";

        $data = $this->client->attach($this->container_id);

        $this->assertEquals($expected, $data);
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
