<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

if (!empty($_SERVER["HTTP_ORIGIN"])) {
    $origin = $_SERVER["HTTP_ORIGIN"];

    header('Access-Control-Allow-Origin:' . $origin);
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: POST,OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type,Authorization');
}
// if (!empty($_SERVER["HTTP_ORIGIN"])) {
//     $origin = $_SERVER["HTTP_ORIGIN"];
//     $allowed_origins = array(
//         "http://localhost",
//         'http://localhost:4200',
//     );
//     if (in_array($origin, $allowed_origins, true) === true) {
//     }
// }

define('LARAVEL_START', microtime(true));
/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
 */

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
 */

$app = require_once __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
 */

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();
if(!empty($_SERVER['REDIRECT_URL'])){ 
    App\Utils::log2("GET : " . json_encode($_GET) . "\n" . "POST : " . json_encode($_POST) . "\n" . "REDIRECT_URL : " . $_SERVER['REDIRECT_URL']);
}

$kernel->terminate($request, $response);
