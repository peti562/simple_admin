<?php

use Phinx\Migration\AbstractMigration;

class CreatePageTable extends AbstractMigration
{
    public function change()
    {
        $this->table('page', [
            'id'        => 'p_id',
            'length'    => 11,
            'signed'    => false
        ])
            ->addColumn('p_name', 'string', [
                'length'    => 255,
                'null'      => false
            ])
            ->addColumn('p_formatted_name', 'string', [
                'length'    => 255,
                'null'      => false
            ])
            ->addColumn('p_title', 'string', [
                'length'    => 255,
                'null'      => false
            ])
            ->addColumn('p_url', 'string', [
                'length'    => 255,
                'null'      => false
            ])
            ->create();
    }
}
