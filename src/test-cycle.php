<?php declare(strict_types=1);
include 'init.php';

use App\Cycle\User;
use Cycle\Schema;
use Cycle\Annotated;
use Cycle\Database;
use Cycle\Database\Config;
use Cycle\ORM;

/** --------------------------- SETUP START --------------------------- */
$dbal = new Database\DatabaseManager(
    new Config\DatabaseConfig([
        'default' => 'default',
        'databases' => [
            'default' => ['connection' => 'mysql']
        ],
        'connections' => [
            'mysql' => new Config\MySQLDriverConfig(
                connection: new Config\MySQL\TcpConnectionConfig(
                    database: $_ENV['MYSQL_DB_NAME'],
                    host: $_ENV['MYSQL_HOST'],
                    port: $_ENV['MYSQL_HOST_PORT'],
                    user: $_ENV['MYSQL_USERNAME'],
                    password: $_ENV['MYSQL_PASSWORD'],
                ),
            ),
        ]
    ])
);

$finder = (new \Symfony\Component\Finder\Finder())->files()->in([__DIR__ . '/Cycle']); // __DIR__ here is folder with entities
$classLocator = new \Spiral\Tokenizer\ClassLocator($finder);

$schema = (new Schema\Compiler())->compile(new Schema\Registry($dbal), [
    new Schema\Generator\ResetTables(),             // re-declared table schemas (remove columns)
    new Annotated\Embeddings($classLocator),        // register embeddable entities
    new Annotated\Entities($classLocator),          // register annotated entities
    new Annotated\TableInheritance(),               // register STI/JTI
    new Annotated\MergeColumns(),                   // add @Table column declarations
    new Schema\Generator\GenerateRelations(),       // generate entity relations
    new Schema\Generator\GenerateModifiers(),       // generate changes from schema modifiers
    new Schema\Generator\ValidateEntities(),        // make sure all entity schemas are correct
    new Schema\Generator\RenderTables(),            // declare table schemas
    new Schema\Generator\RenderRelations(),         // declare relation keys and indexes
    new Schema\Generator\RenderModifiers(),         // render all schema modifiers
    new Annotated\MergeIndexes(),                   // add @Table column declarations
    new Schema\Generator\SyncTables(),              // sync table changes to database
    new Schema\Generator\GenerateTypecast(),        // typecast non string columns
]);
$orm = new ORM\ORM(
    factory: new ORM\Factory($dbal),
    schema: new ORM\Schema($schema),
);
$entityManager = new ORM\EntityManager($orm);
$repository = $orm->getRepository(User::class);
// Complete ORM configuration
$orm->prepareServices();
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
    $entityManager->persist($newUser);
    $entityManager->run();

    // Clean entity cache before next action
    $orm->getHeap()->clean();
    //Read
    $foundUser = $repository->findByPK($newUser->getId());

    //Update
    $foundUser->setName($foundUser->getName() . '_changed');
    $entityManager->persist($foundUser);
    $entityManager->run();

    //Delete
    $entityManager->delete($foundUser);
    $entityManager->run();
}

$time = microtime(true) - $startTime;
$memory = memory_get_usage() - $startMemory;
$memoryPeak = memory_get_peak_usage();
printf(
    "CYCLE %d CRUD operations\nTime: %s seconds\nMemory: %s Kilobytes\nMemory Peak: %s Kilobytes\n",
    $_ENV['REPEATS'],
    round($time, 2),
    round($memory / 1024, 2),
    round($memoryPeak / 1024, 2),
);