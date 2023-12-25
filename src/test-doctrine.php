<?php
include 'init.php';

use App\Doctrine\User;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM;

/** --------------------------- SETUP START --------------------------- */
$connection = DriverManager::getConnection([
    'driver' => 'pdo_mysql',
    'dbname' => $_ENV['MYSQL_DB_NAME'],
    'user' => $_ENV['MYSQL_USERNAME'],
    'password' => $_ENV['MYSQL_PASSWORD'],
    'host' => $_ENV['MYSQL_HOST'],
    'port' => $_ENV['MYSQL_HOST_PORT'],
]);
$config = ORM\ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/Doctrine'], true);
$entityManager = new ORM\EntityManager($connection, $config);
$repository = $entityManager->getRepository(User::class);
/** --------------------------- SETUP END --------------------------- */

$startTime = microtime(true);
$startMemory = memory_get_usage();

for ($i = 0; $i < $_ENV['REPEATS']; $i++) {
    $newUser = new User(
        name: uniqid(),
        age: mt_rand(1, 100),
        microtime: microtime(true),
    );
    //Create
    $entityManager->persist($newUser);
    $entityManager->flush();

    //Otherwise, the Doctrine will retrieve the entity from the local php cache
    //instead of executing an actual 'SELECT' query
    $entityManager->getUnitOfWork()->detach($newUser);

    //Read
    $foundUser = $repository->find($newUser->getId());

    //Update
    $foundUser->setName($foundUser->getName() . '_changed');
    $entityManager->persist($foundUser);
    $entityManager->flush();

    //Delete
    $entityManager->remove($foundUser);
    $entityManager->flush();
}

$time = microtime(true) - $startTime;
$memory = memory_get_usage() - $startMemory;
$memoryPeak = memory_get_peak_usage();
printf(
    "DOCTRINE %d CRUD operations\nTime: %s seconds\nMemory: %s Kilobytes\nMemory Peak: %s Kilobytes\n",
    $_ENV['REPEATS'],
    round($time, 2),
    round($memory / 1024, 2),
    round($memoryPeak / 1024, 2),
);

