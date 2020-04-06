<?php

namespace App\Views;

use App\Base;
use App\Helpers\Env;

class View extends Base {

    public $env;

    public function __construct()
    {
        $this->env = new Env();
    }

    /**
     * @param $name
     * @param array $compact
     */
    public function render($name, $compact = [])
    {
        extract($compact);
        require 'views/'.$name.'.php';
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->$key = $value;
    }

}
