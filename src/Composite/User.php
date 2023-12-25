<?php declare(strict_types=1);
namespace App\Composite;

use Composite\DB\Attributes\{Table, PrimaryKey};
use Composite\Entity\AbstractEntity;

#[Table(connection: 'mysql', name: 'Users')]
class User extends AbstractEntity
{
    #[PrimaryKey(autoIncrement: true)]
    public readonly int $id;

    public function __construct(
        public string $name,
        public int $age,
        public float $microtime,
        public \DateTimeImmutable $created_at = new \DateTimeImmutable(),
    ) {}
}
