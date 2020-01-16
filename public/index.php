<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\App;
use App\Services\Bowling\Calculator;

/*
|--------------------------------------------------------------------------
| Runs the app
|--------------------------------------------------------------------------
*/
$app = new App(new Calculator());
try {
    $app->start();
} catch (Exception $e) {
    echo sprintf('ERROR: %s', $e->getMessage());
}
