<?php

namespace App\Entity;

class User extends BaseEntity
{
	const MAPPING_KEY = 'USER';

    protected $tablePrefix = 'u_';
	protected $username;
	protected $password;
	protected $loginAttempts;
    protected $roles;
    protected $pages;
    protected $lastSeen;

    public function getUsername() : string
    {
        return $this->username;
    }

    public function setUsername(string $username) : self
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;
        return $this;
    }

    public function getLoginAttempts() : int
    {
        return $this->loginAttempts;
    }

    public function setLoginAttempts(int $loginAttempts) : self
    {
        $this->loginAttempts = $loginAttempts;
        return $this;
    }

    public function getRoles() : array
    {
        return $this->roles;
    }

    public function setRoles(array $roles) : self
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPages() : array
    {
        return $this->pages;
    }

    public function setPages(array $pages) : self
    {
        $this->pages = $pages;
        return $this;
    }

    public function getLastSeen()
    {
        return $this->lastSeen;
    }

    public function setLastSeen($lastSeen) : self
    {
        $this->lastSeen = $lastSeen;
        return $this;
    }
}
