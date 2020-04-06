<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ErrorController extends BaseController {

  function __construct() {
    parent::__construct();
  }

  function index() {
    // admin auth and messages
    $this->initAdmin();

    $this->view->title = '404 Error';
    $this->view->msg = 'This page does not exist';

    $this->view->render('admin/header');
    $this->view->render('admin/error/index');
    $this->view->render('admin/footer');

  }

}
