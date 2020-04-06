<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entity\Page;
use App\Entity\User;

class DashboardController extends BaseController {

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {

        // admin auth and messages
        $this->initAdmin();
        $this->view->user = $this->pageModel->getPagesForUser($this->view->user);

        $this->view->user = $this->getLastSeenForUser($this->view->user);
        $this->view->page = $this->getFirstPageForUser($this->view->user, 'dashboard');

        $this->view->title = 'Udv itt bent';

        $this->view->render('admin/header');
        $this->view->render('admin/dashboard/index');
        $this->view->render('admin/footer');
    }
}
