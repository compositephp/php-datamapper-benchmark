<?php declare(strict_types=1);

namespace App\Laravel;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    const UPDATED_AT = null;

    protected $table = 'Users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'age',
        'microtime',
        'created_at',
    ];

    public function getId(): int
    {
        return (int)$this->getAttribute('id');
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    public function setName(string $value): User
    {
        $this->setAttribute('name', $value);
        return $this;
    }
}