<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 06.08.2017
 * Time: 12:32
 */

namespace Controller;


use Core\Controller;

class ProjectController extends Controller
{
    public function actionIndex()
    {
        // TODO: Implement actionIndex() method.
    }

    public function actionCreate()
    {
        $this->view->render('project/create');
    }
}