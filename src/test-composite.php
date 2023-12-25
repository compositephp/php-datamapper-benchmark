<?php declare(strict_types=1);
include 'init.php';

use App\Composite\User;
use App\Composite\UsersTable;

/** --------------------------- SETUP START --------------------------- */
$table = new UsersTable();
/** --------------------------- SETUP END --------------------------- */

$startTime = microtime(true);
$startMemory = memory_get_usage();

for ($i = 0; $i < $_ENV['REPEATS']; $i++) {
    //Create
    $newUser = new User(
        name: uniqid(),
        age: mt_rand(1, 100),
        microtime: microtime(true),
    );
    $table->save($newUser);

    //Read
    $foundUser = $table->findOne($newUser->id);

    //Update
    $foundUser->name = $foundUser->name . '_changed';
    $table->save($foundUser);

    //Delete
    $table->delete($foundUser);
}

$time = microtime(true) - $startTime;
$memory = memory_get_usage() - $startMemory;
$memoryPeak = memory_get_peak_usage();
printf(
    "COMPOSITE %d CRUD operations\nTime: %s seconds\nMemory: %s Kilobytes\nMemory Peak: %s Kilobytes\n",
    $_ENV['REPEATS'],
    round($time, 2),
    round($memory / 1024, 2),
    round($memoryPeak / 1024, 2),
);