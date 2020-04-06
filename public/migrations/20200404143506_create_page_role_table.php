<?php

use Phinx\Migration\AbstractMigration;

class CreatePageRoleTable extends AbstractMigration
{
    public function change()
    {
        $this->table('page_role', [
            'id'        => 'pr_id',
            'length'    => 11,
            'signed'    => false
        ])
            ->addColumn('fk_page_id', 'integer', [
                'length'    => 11,
                'signed'    => false,
                'null'      => false
            ])
            ->addColumn('fk_role_id', 'integer', [
                'length'    => 11,
                'signed'    => false,
                'null'      => true
            ])
            ->addIndex(['fk_page_id', 'fk_role_id'], ['unique' => true])
            ->addForeignKey('fk_role_id', 'role', 'r_id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->addForeignKey('fk_page_id', 'page', 'p_id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->create();
    }
}
