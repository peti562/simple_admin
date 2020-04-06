<?php

use Phinx\Migration\AbstractMigration;

class CreateUserSessionTable extends AbstractMigration
{

    public function change()
    {
        $this->table('user_session', [
            'id'        => 'us_id',
            'length'    => 11,
            'signed'    => false,
        ])
            ->addColumn('fk_user_id', 'integer', [
                'length'    => 11,
                'null'      => false,
                'signed'    => false,
            ])
            ->addColumn('us_created_at', 'timestamp', [
                'default'   => 'CURRENT_TIMESTAMP',
            ])
            ->addColumn('us_login_successful', 'boolean', [
                'default'   => false,
            ])
            ->addForeignKey('fk_user_id', 'user', 'u_id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->create();
    }
}
