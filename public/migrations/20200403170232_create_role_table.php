<?php

use Phinx\Migration\AbstractMigration;

class CreateRoleTable extends AbstractMigration
{

    public function change()
    {
        $this->table('role', [
            'id'     => 'r_id',
            'length' => 11,
            'signed' => false,
        ])
            ->addColumn('r_name', 'string', [
                'length' => 50,
                'null'   => false,
            ])
            ->create();
    }
}
