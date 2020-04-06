<?php

namespace App\Entity;

class Role extends BaseEntity
{
	const MAPPING_KEY = 'ROLE';

    protected $tablePrefix = 'r_';

	protected $name;

	public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }
}
