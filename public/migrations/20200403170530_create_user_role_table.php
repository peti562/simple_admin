<?php

use Phinx\Migration\AbstractMigration;

class CreateUserRoleTable extends AbstractMigration
{
    public function change()
    {
        $this->table('user_role', [
            'id'        => 'ur_id',
            'length'    => 11,
            'signed'    => false
        ])
            ->addColumn('fk_user_id', 'integer', [
                'length'    => 11,
                'signed'    => false,
                'null'      => false
            ])
            ->addColumn('fk_role_id', 'integer', [
                'length'    => 11,
                'signed'    => false,
                'null'      => true
            ])
            ->addIndex(['fk_user_id', 'fk_role_id'], ['unique' => true])
            ->addForeignKey('fk_role_id', 'role', 'r_id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->addForeignKey('fk_user_id', 'user', 'u_id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->create();
    }
}
