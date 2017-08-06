<?php
/**
 *  Main Controller class
 */
namespace Controller;

use Core\Controller;
use Core\Message;
use Core\Router;
use Model\User;

class RegisterController extends Controller
{
    public $message;

    /**
     * Generate register page
     */
    public function actionIndex()
    {
        $this->view->render('register');
    }

    public function actionRegister()
    {
        $model = new User();
        $model->login = filter_input(INPUT_POST, 'login');
        $model->password = filter_input(INPUT_POST, 'password');
        $model->passwordConfirm = filter_input(INPUT_POST, 'password_confirm');

        if (!$model->validate()) {
            $this->view->render('register', [
                'oldLogin' => $model->login,
            ]);
        } else {
            if ($model->save()) {
                Message::Success('You have successfully registered');
            } else {
                Message::Error('Someting wrong');
            }
            Router::redirect('/login');
        }
    }
}