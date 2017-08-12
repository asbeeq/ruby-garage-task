<?php

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
        $projectId = filter_input(INPUT_POST, 'project-id', FILTER_VALIDATE_INT);
        $task = filter_input(INPUT_POST, 'task');

        if (!empty($projectId) && !empty($task)) {
            if (Router::isAjax()) {
                $response = [];
                $response['project-id'] = $projectId;
                $model = new Task();
                $model->name = $task;
                $model->projectId = $projectId;
                $model->sortOrder = $model->getSortOrder();

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
        } elseif (empty($task)) {
            $response['status'] = false;
            $response['message'] = View::renderPartial('alerts/alert', [
                'message' => [
                    'type' => MSG_ERROR,
                    'text' => 'The task should not be empty',
                ]
            ]);
            echo json_encode($response);
        }
    }

    public function actionDelete()
    {
        $taskId = filter_input(INPUT_POST, 'task-id', FILTER_VALIDATE_INT);
        $response = [];
        if (!empty($taskId)) {
            if (Router::isAjax()) {
                $response['task_id'] = $taskId;
                $model = new Task();
                $model->findTaskById($taskId);

                if ($model->delete()) {
                    $response['status'] = true;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_SUCCESS,
                            'text' => 'Task successfully deleted',
                        ]
                    ]);
                } else {
                    $response['status'] = false;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_ERROR,
                            'text' => 'Task not deleted',
                        ]
                    ]);
                }
                echo json_encode($response);
                return;
            }
        }

    }

    public function actionSort()
    {
        $order = filter_input(INPUT_POST, 'order', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
        $response = [];
        if (!empty($projectId) && count($order) > 0) {
            if (Router::isAjax()) {
                $model = new Task();
                $model->sortOrder($order);
                $response['status'] = true;
                echo json_encode($response);
                return;
            }
        }
    }
}