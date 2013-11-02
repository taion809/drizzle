<?php

namespace Johnsn\Drizzle\Client;

use Guzzle\Http\Client;
use Johnsn\Drizzle\Contracts\ClientInterface;

class GuzzleClient extends Client implements ClientInterface
{
    protected $request = null;

    public function __construct($endpoint = 'http://127.0.0.1:4243', $version = 'v1.6', array $options = array())
    {
        if(!array_key_exists("version", $options)) {
            $options['version'] = $version;
        }

        if(substr($endpoint, -1, 1) == '/') {
            $endpoint .= "{version}/";
        } else {
            $endpoint .= "/{version}/";
        }

        parent::__construct($endpoint, $options);
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function build($uri, array $fields = array())
    {
        if(!empty($fields)) {
            $uri .= "?" . http_build_query($fields);
        }

        $this->request = $this->get($uri);

        return $this;
    }

    public function buildJson($uri, array $fields = array())
    {
        if(!empty($fields)) {
            $this->request = $this->post($uri, array("Content-type" => "application/json"), json_encode($fields));
        } else {
            $this->request = $this->post($uri);
        }

        return $this;
    }

    public function sendRequest($format = 'json')
    {
        $message = array();

        try
        {
            $response = $this->request->send();
            
            $message['status'] = $response->getStatusCode();
            
            if($format == 'json') {
                $message['data'] = $response->json();
            } else {
                $message['data'] = $response->getBody();
            }

        } catch (RuntimeException $e) {
            $message['status'] = '500';
            $message['data'] = $e->getMessage();
        } catch(\Guzzle\Http\Exception\CurlException $e) {
            $message['status'] = '500';
            $message['data'] = $e->getMessage();
        } catch(\Guzzle\Http\Exception\ClientErrorResponseException $e) {
            $message['status'] = $e->getResponse()->getStatusCode();
            $message['data'] = $e->getRequest()->getUrl() . " : " . $e->getResponse()->getReasonPhrase();
        }

        return $message;
    }
}
