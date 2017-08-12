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
                $this->view->setPageTitle('Create Project')->render('project/create', [
                    'oldName' => $model->name,
                ]);
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
                if ($model->delete()) {
                    $response['status'] = true;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_SUCCESS,
                            'text' => 'Project successfully deleted',
                        ]
                    ]);
                } else {
                    $response['status'] = false;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_ERROR,
                            'text' => 'Project not deleted',
                        ]
                    ]);
                }
                echo json_encode($response);
                return;
            }
        }
    }

    public function actionUpdate()
    {
        $projectId = filter_input(INPUT_POST, 'project-id');
        $newName = filter_input(INPUT_POST, 'new-name');

        if ($projectId && $newName) {
            if (Router::isAjax()) {
                $response = [];
                $response['project-id'] = $projectId;
                $model = new Project();
                $model->findById($projectId);
                if ($model->update($newName)) {
                    $response['status'] = true;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_SUCCESS,
                            'text' => 'Project successfully updated',
                        ]
                    ]);
                } else {
                    $response['status'] = false;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_ERROR,
                            'text' => 'Project not updated',
                        ]
                    ]);
                }
                echo json_encode($response);
                return;
            }
        }
    }
}