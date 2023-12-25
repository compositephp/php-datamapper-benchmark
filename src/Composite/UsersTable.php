<?php declare(strict_types=1);

namespace App\Composite;

use Composite\DB\AbstractTable;
use Composite\DB\TableConfig;

class UsersTable extends AbstractTable
{
    protected function getConfig(): TableConfig
    {
        return TableConfig::fromEntitySchema(User::schema());
    }

    public function findOne(int $id): ?User
    {
        return $this->_findByPk($id);
    }
}
