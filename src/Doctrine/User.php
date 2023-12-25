<?php declare(strict_types=1);

namespace App\Doctrine;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "Users")]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue]
    private int $id;

    public function __construct(
        #[ORM\Column(type: "string")]
        private string $name,
        #[ORM\Column(type: "integer")]
        private int $age,
        #[ORM\Column(type: "float")]
        private float $microtime,
        #[ORM\Column(type: "datetime")]
        private \DateTime $created_at = new \DateTime(),
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