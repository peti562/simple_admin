<?php

namespace App\Entity;

class Page extends BaseEntity
{
	const MAPPING_KEY = 'PAGE';

    protected $tablePrefix = 'p_';
	protected $name;
    protected $formattedName;
    protected $title;
    protected $url;

	public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    public function getFormattedName() : string
    {
        return $this->formattedName;
    }

    public function setFormattedName(string $formattedName) : self
    {
        $this->formattedName = $formattedName;
        return $this;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle(string $title) : self
    {
        $this->title = $title;
        return $this;
    }

    public function getUrl() : string
    {
        return $this->url;
    }

    public function setUrl(string $url) : self
    {
        $this->url = $url;
        return $this;
    }
}
