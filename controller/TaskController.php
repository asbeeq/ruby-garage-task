<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 10.08.2017
 * Time: 22:40
 */

namespace Controller;


use Core\Controller;
use Model\Task;
use Core\Router;
use Core\View;

class TaskController extends Controller
{
    public function actionIndex(){}

    public function actionCreate()
    {
        $projectId = filter_input(INPUT_POST, 'project-id');
        $task = filter_input(INPUT_POST, 'task');

        if ($projectId && $task) {
            if (Router::isAjax()) {
                $response = [];
                $response['project-id'] = $projectId;
                $model = new Task();
                $model->name = $task;
                $model->projectId = $projectId;
                $model->priority = $model->getPriority();

                if ($id = $model->save()) {
                    $response['status'] = true;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_SUCCESS,
                            'text' => 'Task successfully created',
                        ]
                    ]);
                    $response['task_block'] = View::renderPartial('partial/task', [
                        'task' => [
                            'id' => $id,
                            'name' => $model->name,
                        ],
                    ]);
                } else {
                    $response['status'] = false;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_ERROR,
                            'text' => 'Task not created',
                        ]
                    ]);
                }
                echo json_encode($response);
                return;
            }
        }
    }
}