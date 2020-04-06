<?php

use Phinx\Migration\AbstractMigration;

class CreateUserTable extends AbstractMigration
{
    public function change()
    {
        $this->table('user', [
            'id'     => 'u_id',
            'length' => 11,
            'signed' => false,
        ])
            ->addColumn('u_username', 'string', [
                'length' => 50,
                'null'   => false,
            ])
            ->addColumn('u_password', 'string', [
                'length' => 255,
                'null'   => true,
            ])
            ->addColumn('u_login_attempts', 'integer', [
                'length'  => 1,
                'null'    => false,
                'default' => 0,
            ])
            ->create();
    }
}
