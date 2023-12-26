<?php declare(strict_types=1);

namespace App\Cycle;

class User
{
    private int $id;

    public function __construct(
        private string $name,
        private int $age,
        private float $microtime,
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