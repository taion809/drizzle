drizzle
=======

Stable: [![Build Status](https://travis-ci.org/taion809/drizzle.png?branch=master)](https://travis-ci.org/taion809/drizzle)
Dev: [![Build Status](https://travis-ci.org/taion809/drizzle.png?branch=dev)](https://travis-ci.org/taion809/drizzle)

A simple docker remote api built for packagist ontop of guzzle.

### Example

```php
<?php

require_once __DIR__ . "/vendor/autoload.php";

use Johnsn\Drizzle\Drizzle;

//$endpoint = 'http://127.0.0.1:4243', $version = 'v1.6'
$drizzle = new Drizzle();
$drizzle->connect();

//Return the current docker version
$data = $drizzle->version();

/**
 * $data:
 * array(2) {
 *   ["status"]=>
 *   int(200)
 *   ["data"]=>
 *   array(3) {
 *     ["Version"]=>
 *     string(5) "0.6.4"
 *     ["GitCommit"]=>
 *     string(7) "2f74b1c"
 *     ["GoVersion"]=>
 *     string(7) "go1.1.2"
 *   }
 * }
 */

var_dump($data);

```
