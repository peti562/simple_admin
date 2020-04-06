<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Entity\Page;
use App\Helpers\Session;
use App\Helpers\Cookie;

class IndexController extends BaseController {

    const CAPTCHA_LIMIT = 3;

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        // admin auth and messages
        $this->initAdmin(true);
        $this->view->title = 'Login';
        $this->view->incorrectDetails = Cookie::get('loginAttempts') >= 1;
        $this->view->failedCaptcha = Cookie::get('failedCaptcha');
        $this->view->needCaptcha = Cookie::get('loginAttempts') >= self::CAPTCHA_LIMIT;
        $this->view->render('admin/index/index');
    }

    function run()
    {
        if (intval(Cookie::get('loginAttempts')) >= self::CAPTCHA_LIMIT) {
            if (!isset($_POST['g-recaptcha-response'])) {
                header('location: '.$this->env->get('url').'admin');
                exit;
            }

            // post request to server
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' .
                urlencode($this->env->get('google.secret_key')) .
                '&response=' .
                urlencode($_POST['g-recaptcha-response']);
            $res = file_get_contents($url);
            $response = json_decode($res,true);

            if(!$response['success']) {
                Cookie::set('failedCaptcha', true);
                header('location: '.$this->env->get('url').'admin');
                exit;
            }
        }

        Cookie::set('failedCaptcha', false);
        // get our user
        $user = $this->login();

        if ($user) {
            // attach the pages he's allowed to see
            $user = $this->pageModel->getPagesForUser($user);
            // get the first page
            /** @var Page $firstPage */
            $firstPage = current($user->getPages());

            header('location: '.$this->env->get('url').'admin/' . $firstPage->getUrl());
        } else {
            header('location: '.$this->env->get('url').'admin');
        }
    }

    function logout()
    {
        Session::destroy();
        Cookie::destroy();
        header('location: '.$this->env->get('url').'admin');
        exit;
    }


}
