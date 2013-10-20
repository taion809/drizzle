drizzle
=======

Stable: [![Build Status](https://travis-ci.org/taion809/drizzle.png?branch=master)](https://travis-ci.org/taion809/drizzle)
Dev: [![Build Status](https://travis-ci.org/taion809/drizzle.png?branch=dev)](https://travis-ci.org/taion809/drizzle)

A simple docker remote api built for packagist ontop of guzzle.

### Example

```php
<?php

require_once __DIR__ . "/vendor/autoload.php";

use Guzzle\Http\Client;
use Johnsn\Drizzle\Drizzle;

try
{
    $client = new Client("http://127.0.0.1:4243/{version}", array("version" => "v1.6"));
    $d = new Drizzle($client);

    $data = $d->version();
    var_dump($data);

    $data = $d->containers();
    var_dump($data);

} catch(\Guzzle\Http\Exception\CurlException $e) {
    var_dump($e->getMessage());
}
```