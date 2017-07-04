<?php
/**
 *  Main Controller class
 */
namespace controller;

use core\Controller;

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