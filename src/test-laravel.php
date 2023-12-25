<?php declare(strict_types=1);
include 'init.php';

use App\Laravel\User;
use Illuminate\Database\Capsule\Manager;

/** --------------------------- SETUP START --------------------------- */
$manager = new Manager;
$manager->addConnection([
    'driver' => 'mysql',
    'host' => $_ENV['MYSQL_HOST'],
    'port' => $_ENV['MYSQL_HOST_PORT'],
    'database' => $_ENV['MYSQL_DB_NAME'],
    'username' => $_ENV['MYSQL_USERNAME'],
    'password' => $_ENV['MYSQL_PASSWORD'],
]);
$manager->setAsGlobal();
$manager->bootEloquent();
/** --------------------------- SETUP END --------------------------- */

$startTime = microtime(true);
$startMemory = memory_get_usage();

for ($i = 0; $i < $_ENV['REPEATS']; $i++) {
    //Create
    /** @var User $newUser */
    $newUser = User::create([
        'name' => uniqid(),
        'age' => mt_rand(1, 100),
        'microtime' => microtime(true),
        'created_at' => new \DateTimeImmutable(),
    ]);
    //Read
    /** @var User $foundUser */
    $foundUser = User::find($newUser->getId());

    //Update
    $foundUser->setName($foundUser->getName() . '_changed');
    $foundUser->save();

    //Delete
    $foundUser->delete();
}

$time = microtime(true) - $startTime;
$memory = memory_get_usage() - $startMemory;
$memoryPeak = memory_get_peak_usage();
printf(
    "LARAVEL %d CRUD operations\nTime: %s seconds\nMemory: %s Kilobytes\nMemory Peak: %s Kilobytes\n",
    $_ENV['REPEATS'],
    round($time, 2),
    round($memory / 1024, 2),
    round($memoryPeak / 1024, 2),
);