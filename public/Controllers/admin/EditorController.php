<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entity\Page;

class EditorController extends BaseController {

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        // admin auth and messages
        $this->initAdmin();


        $this->view->user = $this->getLastSeenForUser($this->view->user);
        $this->view->page = $this->getFirstPageForUser($this->view->user, 'editor');

        if (is_null($this->view->page)) {
            header('location: '.$this->env->get('url').'admin');
        }

        $this->view->title = 'Udv itt bent';

        $this->view->render('admin/header');
        $this->view->render('admin/editor/index');
        $this->view->render('admin/footer');
    }
}
