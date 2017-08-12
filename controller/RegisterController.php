<?php
/**
 *  Main Controller class
 */
namespace Controller;

use Core\Controller;
use Libs\Message;
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
        $this->view->setPageTitle('Register')->render('auth/register');
    }

    public function actionRegister()
    {
        $model = new User();
        $model->login = filter_input(INPUT_POST, 'login');
        $model->email = filter_input(INPUT_POST, 'email');
        $model->password = filter_input(INPUT_POST, 'password');
        $model->passwordConfirm = filter_input(INPUT_POST, 'password_confirm');

        if (!$model->validate()) {
            $this->view->setPageTitle('Register')->render('auth/register', [
                'oldLogin' => $model->login,
                'oldEmail' => $model->email,
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