<?php

namespace Controller;

use Core\Controller;
use Core\Router;
use Model\Project;
use Model\User;
use Libs\Message;

class ProjectController extends Controller
{
    public function actionIndex()
    {
        $this->view->render('project/create');
    }

    public function actionCreate()
    {
        $model = new Project();
        if ($userId = User::isLogin()) {
            $model->name = filter_input(INPUT_POST, 'name');
            $model->userId = $userId;

            if ($model->validate()) {
                if ($model->save()) {
                    Message::Success('You have successfully add project');
                } else {
                    Message::Error('Someting wrong');
                }
                Router::redirect('/');
            } else {
                $this->view->render('project/create', [
                    'oldName' => $model->name,
                ]);
            }
        }
    }

    public function actionDelete()
    {
        echo "OK";
    }
}