<?php declare(strict_types=1);

namespace App\Cycle;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;

#[Entity(table: 'Users', database: 'default')]
class User
{
    #[Column(type: 'primary')]
    private int $id;

    public function __construct(
        #[Column(type: 'string')]
        private string $name,
        #[Column(type: 'integer')]
        private int $age,
        #[Column(type: 'float')]
        private float $microtime,
        #[Column(type: 'timestamp')]
        private \DateTimeImmutable $created_at = new \DateTimeImmutable(),
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): User
    {
        $this->age = $age;
        return $this;
    }

    public function getMicrotime(): float
    {
        return $this->microtime;
    }

    public function setMicrotime(float $microtime): User
    {
        $this->microtime = $microtime;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): User
    {
        $this->created_at = $created_at;
        return $this;
    }
}