<?php

namespace App\Entity;

class UserSession extends BaseEntity
{
	const MAPPING_KEY = 'USER_SESSION';

    protected $tablePrefix = 'us_';
	protected $userId;
	protected $createdAt;
	protected $loginSuccessful;

    public function getUserId() : string
    {
        return $this->userId;
    }

    public function setUserId(string $userId) : self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getCreatedAt() : \DateTime
    {
        return $this->setDate($this->createdAt);
    }

    public function setCreatedAt(\DateTime $createdAt) : self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getLoginSuccessful() : bool
    {
        return $this->loginSuccessful;
    }

    public function setLoginSuccessful(bool $loginSuccessful) : self
    {
        $this->loginSuccessful = $loginSuccessful;
        return $this;
    }
}
