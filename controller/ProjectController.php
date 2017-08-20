<?php

namespace Controller;

use Core\Controller;
use Core\Router;
use Core\View;
use Model\Project;
use Model\User;
use Libs\Message;

class ProjectController extends Controller
{
    public function actionIndex()
    {
        $this->view->setPageTitle('Create Project')->render('project/create');
    }

    public function actionCreate()
    {
        $projectName = filter_input(INPUT_POST, 'project-name');

        if ($projectName && $userId = User::isLogin()) {
            if (Router::isAjax()) {
                $model = new Project();
                $model->name = $projectName;
                $model->userId = $userId;

                $response = [];
                if ($model->validate() && $id = $model->save()) {
                    $response['status'] = true;
                    $response['project_block'] = View::renderPartial('partial/project', [
                        'project' => [
                            'id' => $id,
                            'name' => $model->name,
                        ]
                    ]);
                } else {
                    $response['status'] = true;
                }

                echo json_encode($response);
                return;
            }
        }
    }

    public function actionDelete()
    {
        if ($id = filter_input(INPUT_POST, 'project-id')) {
            if (Router::isAjax()) {
                $response = [];
                $response['project'] = $id;
                $model = new Project();
                $model->findById($id);
                $response['status'] = $model->delete() ? true : false;
                echo json_encode($response);
                return;
            }
        }
    }

    public function actionUpdate()
    {
        $projectId = filter_input(INPUT_POST, 'project-id', FILTER_VALIDATE_INT);
        $newName = filter_input(INPUT_POST, 'new-name');

        if ($projectId && $newName) {
            if (Router::isAjax()) {
                $response = [];
                $response['project-id'] = $projectId;
                $model = new Project();
                $model->findById($projectId);
                $response['status'] = $model->update($newName) ? true : false;
                echo json_encode($response);
                return;
            }
        }
    }
}