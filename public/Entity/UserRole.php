<?php

namespace App\Entity;

class UserRole extends BaseEntity
{
	const MAPPING_KEY = 'USER_ROLE';

    protected $tablePrefix = 'ur_';

	protected $userId;

	protected $roleId;

    protected $name;

	public function getUserId() : string
    {
        return $this->userId;
    }

    public function setUserId(string $userId) : self
    {
        $this->userId = $userId;
        return $this;
    }

    public function getRoleId() : string
    {
        return $this->roleId;
    }

    public function setRoleId(string $roleId) : self
    {
        $this->roleId = $roleId;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name) : self
    {
        $this->name = $name;
        return $this;
    }
}
