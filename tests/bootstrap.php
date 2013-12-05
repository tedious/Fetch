<?php

/*
 * This file is part of the Fetch library.
 *
 * (c) Robert Hafner <tedivm@tedivm.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

error_reporting(-1);

define('TESTING', true);
define('TEST_USER', 'testuser');
define('TEST_PASSWORD', 'applesauce');

if(getenv('TRAVIS'))
{
    define('TESTING_ENVIRONMENT', 'TRAVIS');
    define('TESTING_SERVER_HOST', '127.0.0.1');
}else{
    define('TESTING_ENVIRONMENT', 'VAGRANT');
    define('TESTING_SERVER_HOST', '172.31.1.2');
    echo 'Initializing Environment using Vagrant' . PHP_EOL;
    passthru('/bin/bash ' . __DIR__ . '/SetupEnvironment.sh');
    echo 'Environment Initialized' . PHP_EOL . PHP_EOL . PHP_EOL;
}

$filename = __DIR__ .'/../vendor/autoload.php';

if (!file_exists($filename)) {
    echo "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~" . PHP_EOL;
    echo " You need to execute `composer install` before running the tests. " . PHP_EOL;
    echo "         Vendors are required for complete test execution.        " . PHP_EOL;
    echo "~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~" . PHP_EOL . PHP_EOL;
    $filename = __DIR__ .'/../autoload.php';
    require_once $filename;
}else{
    $loader = require_once $filename;
    $loader->add('Fetch\\Test', __DIR__);
}