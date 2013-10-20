<?php

namespace Johnsn\Drizzle\Contracts;

interface ClientInterface
{
    public function setRequest($request);
    public function getRequest();
    public function build($uri, array $fields);
    public function buildJson($uri, array $fields);    
    public function sendRequest($format);
}
