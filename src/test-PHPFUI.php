<?php declare(strict_types=1);

include 'init.php';

\PHPFUI\ORM::$namespaceRoot = __DIR__ . '/src';
\PHPFUI\ORM::$recordNamespace = 'PHPFUIORM\\Record';
\PHPFUI\ORM::$tableNamespace = 'PHPFUIORM\\Table';
\PHPFUI\ORM::$migrationNamespace = 'PHPFUIORM\\Migration';
\PHPFUI\ORM::$idSuffix = 'id';

$pdo = new \PHPFUI\ORM\PDOInstance("mysql:host={$_ENV['MYSQL_HOST']};dbname={$_ENV['MYSQL_DB_NAME']};port={$_ENV['MYSQL_HOST_PORT']};charset=utf8mb4;collation=utf8mb4_general_ci", $_ENV['MYSQL_USERNAME'], $_ENV['MYSQL_PASSWORD']);

\PHPFUI\ORM::addConnection($pdo);

/** --------------------------- SETUP END --------------------------- */

$startTime = microtime(true);
$startMemory = memory_get_usage();

for ($i = 0; $i < $_ENV['REPEATS']; $i++) {
    //Create
		/** @var \PHPFUIORM\Record\Users $newUser */
    $newUser = new \PHPFUIORM\Record\Users();
		$newUser->name = uniqid();
		$newUser->age = mt_rand(1, 100);
		$newUser->microtime = microtime(true);
    $newUser->created_at = \date('Y-m-d H:i:s');
		$id = $newUser->insert(0);

    //Read
		/** @var \PHPFUIORM\Record\Users $foundUser */
    $foundUser = new \PHPFUIORM\Record\Users($id);

    //Update
    $foundUser->name = $foundUser->name . '_changed';
    $foundUser->update();

    //Delete
    $foundUser->delete();
}

$time = microtime(true) - $startTime;
$memory = memory_get_usage() - $startMemory;
$memoryPeak = memory_get_peak_usage();
printf(
    "PHPFUI/ORM %d CRUD operations\nTime: %s seconds\nMemory: %s Kilobytes\nMemory Peak: %s Kilobytes\n",
    $_ENV['REPEATS'],
    round($time, 2),
    round($memory / 1024, 2),
    round($memoryPeak / 1024, 2),
);