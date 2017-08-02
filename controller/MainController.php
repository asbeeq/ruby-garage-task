<?php
/**
 *  Main Controller class
 */
namespace Controller;

use Core\Controller;

class MainController extends Controller
{

    /**
     * Generate home page
     */
    public function actionIndex()
    {
        $this->view->render('main');
    }
}