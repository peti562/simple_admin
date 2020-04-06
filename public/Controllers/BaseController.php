<?php

namespace App\Controllers;

use App\Base;
use App\Entity\UserSession;
use App\Helpers\Cookie;
use App\Helpers\Env;
use App\Helpers\Hash;
use App\Helpers\Session;
use App\Models\User;
use App\Models\Page;
use App\Views\View;
use DateTime;
use DateTimeZone;
use Pixie\Exception;

class BaseController extends Base {
    public $env;
    public $view;
    public $userModel;
    public $pageModel;

    function __construct()
    {
        Session::init();
        $this->env = new Env();

        $this->view = new View();

        $this->userModel = new User();
        $this->pageModel = new Page();
    }

    // Admin
    public function initAdmin($loginPage = false)
    {
        $this->view->user = $this->checkLoggedIn();

        if ($loginPage) {
            if ($this->view->user) {
                // attach the pages he's allowed to see
                $this->view->user = $this->pageModel->getPagesForUser($this->view->user);
                // get the first page
                /** @var \App\Entity\Page $firstPage */
                $firstPage = current($this->view->user->getPages());

                header('location: '.$this->env->get('url').'admin/' . $firstPage->getUrl());
            }
        } else {
            if (!$this->view->user) {
                header('location:'.$this->env->get('url').'admin');
            }
        }
    }

    public function setUserOnSession($user)
    {

        $this->userModel->createUserSession([
            'userId'    => $user->getId(),
            'success'   => true,
        ]);

        Session::set('loggedIn', true);
        Session::set('user', $user);
    }

    public function checkLoggedIn()
    {

        $activeUserSession = null;

        if (Cookie::has('username') && Cookie::has('password')) {
            $username = Cookie::get('username');
            $password = Cookie::get('password');
            /** @var \App\Entity\User $user */

            // get the user from the cookie
            $user = $this->userModel->getUser([
                'username'  => $username,
                'withRoles' => true,
            ]);

            /** @var UserSession $activeUserSession */
            /** @var UserSession $lastSeen */
            list($activeUserSession, $lastSeen) = $this->userModel->getActiveUserSession($user->getId(), 2);



            if (is_null($activeUserSession)) {
                return false;
            }



            if (!is_null($lastSeen)) {
                $user->setLastSeen($lastSeen->getCreatedAt());
            }

            if (is_null($user->getPassword()) || $user->getPassword() != $password) {
                $this->userModel->createUserSession([
                    'userId'    => $user->getId(),
                    'success'   => false,
                ]);
            }
        }

        if (is_null($activeUserSession)) {
            return false;
        }

        Cookie::set('loginAttempts', 0);


        return Session::get('user');
    }

    /**
     * @return \App\Entity\User|bool
     * @throws Exception
     */
    public function login()
    {

        $username = $_POST['username'];
        $password = Hash::create('sha256', $_POST['password'], $this->env->get('hash_key'));

        /** @var \App\Entity\User $user */
        $user = $this->userModel->getUser([
            'username'  => $username,
            'withRoles' => true,
        ]);

        if (empty($user)) {
            // return message user not found
        }

        if (is_null($user->getPassword()) || $user->getPassword() != $password) {
            $this->userModel->createUserSession([
                'userId'    => $user->getId(),
                'success'   => false,
            ]);
            // return message wrong password
            Cookie::set('loginAttempts', intval(Cookie::get('loginAttempts')) + 1);
            return false;
        }

        // login
        $this->setUserOnSession($user);

        Cookie::set('username', $username);
        Cookie::set('password', $password);
        Cookie::set('loginAttempts', 0);

        return $user;
    }

    /**
     * @param $user
     * @return mixed
     * @throws Exception
     */
    public function getLastSeenForUser($user) {

        list($activeUserSession, $lastSeen) = $this->userModel->getActiveUserSession($user->getId(), 2);

        $user->setLastSeen(is_null($lastSeen) ? null : $lastSeen->getCreatedAt());

        return $user;
    }

    /**
     * @param $user
     * @param $preferredPage
     * @return \App\Entity\Page|null
     */
    public function getFirstPageForUser($user, $preferredPage) {
        $user = $this->pageModel->getPagesForUser($user);

        if (empty($user->getPages())) {
            return null;
        }

        if (count($user->getPages()) == 1) {
            return current($user->getPages());
        }

        /** @var \App\Entity\Page $page */
        foreach ($user->getPages() as $page) {
            if ($page->getUrl() == $preferredPage) {
                return $page;
            }
        }

        return current($user->getPages());
    }
}
