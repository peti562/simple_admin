<?php

namespace App\Controllers;

class IndexController extends BaseController {

    function index()
    {
        header('location: '.$this->env->get('url').'admin');
    }
}