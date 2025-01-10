<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell
 */

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

/**
 * The Laravel framework bootstrap file.
 */
require __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
