<?php

use rave\core\database\DriverFactory;

return [
    'debug' => true,

    'database' => [
        'driver'   => DriverFactory::MYSQL_PDO,
        'host'     => 'localhost',
        'database' => 'test',
        'login'    => 'root',
        'password' => 'root'
    ],

    'error' => [
        '500' => '/internal-server-error',
        '404' => '/not-found',
        '403' => '/forbidden'
    ],

    'encryption' => [
        'mode'   => MCRYPT_MODE_CBC,
        'cypher' => MCRYPT_RIJNDAEL_256,
        'key'    => '32bitskey',
        'iv'     => 'generatediv'
    ]
];