<?php
$projectDir = dirname(__DIR__);
include $projectDir . '/vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable($projectDir);
$dotenv->load();

$connection = \Composite\DB\ConnectionManager::getConnection('mysql');
$connection->executeStatement("DROP TABLE IF EXISTS Users;");
$connection->executeStatement("
    CREATE TABLE IF NOT EXISTS Users
    (
        `id` INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
        `name` VARCHAR(255) NOT NULL,
        `age` INTEGER NOT NULL,
        `microtime` FLOAT NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
    );
");
