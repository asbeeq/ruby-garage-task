<?php

namespace Controller;

use Core\Controller;
use Model\Task;
use Core\Router;
use Core\View;
use Model\Priority;

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
                            'priority_name' => 'not urgent and not important',
                            'priority_color' => 'gray'
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
        if (count($order) > 0) {
            if (Router::isAjax()) {
                $model = new Task();
                $model->sortOrder($order);
                $response['status'] = true;
                echo json_encode($response);
                return;
            }
        }
    }

    public function actionUpdate()
    {
        $taskId = filter_input(INPUT_POST, 'task-id');
        $newName = filter_input(INPUT_POST, 'new-name');

        if ($taskId && $newName) {
            if (Router::isAjax()) {
                $response = [];
                $response['task-id'] = $taskId;
                $model = new Task();
                $model->findTaskById($taskId);
                if ($model->update($newName)) {
                    $response['status'] = true;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_SUCCESS,
                            'text' => 'Task successfully updated',
                        ]
                    ]);
                } else {
                    $response['status'] = false;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_ERROR,
                            'text' => 'Task not updated',
                        ]
                    ]);
                }
                echo json_encode($response);
                return;
            }
        }
    }

    public function actionChangePriority()
    {
        $taskId = filter_input(INPUT_POST, 'task-id', FILTER_VALIDATE_INT);
//        $currentPriority = filter_input(INPUT_POST, 'current-priority', FILTER_VALIDATE_INT);

        if ($taskId) {
            if (Router::isAjax()) {
                $response = [];
                $response['task-id'] = $taskId;
                $model = new Task();
                $model->findTaskById($taskId);
                if ($newPriority = $model->changePriority()) {
                    $response['status'] = true;
                    $response['new_priority_name'] = $newPriority['name'];
                    $response['new_priority_color'] = $newPriority['color'];
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_SUCCESS,
                            'text' => 'Priority successfully updated',
                        ]
                    ]);
                } else {
                    $response['status'] = false;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_ERROR,
                            'text' => 'Priority not updated',
                        ]
                    ]);
                }
                echo json_encode($response);
                return;
            }
        }
    }

    public function actionChangeDeadline()
    {
        $taskId = filter_input(INPUT_POST, 'task-id', FILTER_VALIDATE_INT);
        $deadline = filter_input(INPUT_POST, 'new-deadline');

        $deadline = $deadline == 'clear' ? null : date('Y-m-d H:i:s', strtotime($deadline));

        if ($taskId) {
            if (Router::isAjax()) {
                $response = [];
                $response['task-id'] = $taskId;
                $model = new Task();
                $model->findTaskById($taskId);
                if ($model->changeDeadline($deadline)) {
                    $response['status'] = true;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_SUCCESS,
                            'text' => 'Deadline successfully updated',
                        ]
                    ]);
                } else {
                    $response['status'] = false;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_ERROR,
                            'text' => 'Deadline not updated',
                        ]
                    ]);
                }
                echo json_encode($response);
                return;
            }
        }
    }

    public function actionChangeDone()
    {
        $taskId = filter_input(INPUT_POST, 'task-id', FILTER_VALIDATE_INT);
        $isDone = filter_input(INPUT_POST, 'is-done', FILTER_VALIDATE_BOOLEAN);

        if ($taskId) {
            if (Router::isAjax()) {
                $response = [];
                $response['task-id'] = $taskId;
                $model = new Task();
                $model->findTaskById($taskId);
                if ($model->changeDone($isDone)) {
                    $response['status'] = true;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_SUCCESS,
                            'text' => 'Done successfully updated',
                        ]
                    ]);
                } else {
                    $response['status'] = false;
                    $response['message'] = View::renderPartial('alerts/alert', [
                        'message' => [
                            'type' => MSG_ERROR,
                            'text' => 'Done not updated',
                        ]
                    ]);
                }
                echo json_encode($response);
                return;
            }
        }
    }
}