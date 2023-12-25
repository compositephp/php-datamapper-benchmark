<?php

return [
    'mysql' => [
        'driver' => 'pdo_mysql',
        'dbname' => $_ENV['MYSQL_DB_NAME'],
        'user' => $_ENV['MYSQL_USERNAME'],
        'password' => $_ENV['MYSQL_PASSWORD'],
        'host' => $_ENV['MYSQL_HOST'],
        'port' => $_ENV['MYSQL_HOST_PORT'],
    ],
];