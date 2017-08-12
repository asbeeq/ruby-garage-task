<?php

namespace Controller;

use Core\Controller;
use Libs\Message;
use Core\Router;
use Model\User;

class LoginController extends Controller
{
    public function actionIndex()
    {
        $this->view->setPageTitle('Login')->render('auth/login');
    }

    public function actionLogin()
    {
        $model = new User();
        $model->login = filter_input(INPUT_POST, 'login');
        $model->password = filter_input(INPUT_POST, 'password');

        if ($model->login()) {
            Router::redirect('/');
        } else {
            Message::Error('Login or password entered incorrectly');
            $this->view->setPageTitle('Login')->render('auth/login');
        }
    }

    public function actionLogout()
    {
        User::logout();
        Router::redirect('/');
    }
}