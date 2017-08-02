<?php
/**
 *  Main Controller class
 */
namespace Controller;

use Core\Controller;

class RegisterController extends Controller
{

    /**
     * Generate register page
     */
    public function actionIndex()
    {
        $this->view->render('register');
    }
}