<?php

use rave\core\database\DriverFactory;

return [
    'debug' => true,

    'database' => [
        'driver'   => DriverFactory::MYSQL_PDO,
        'host'     => 'localhost',
        'database' => 'trans',
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
        'key'    => 'c70911343b8a3b94f5780ce5e65d2daa',
        'iv'     => 'dc4931bc7b44eebb62e4e5e590a54461401b8ea9d9b39546d7aab4b44cdfe3c6'
    ]
];