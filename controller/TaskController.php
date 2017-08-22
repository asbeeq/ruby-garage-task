<?php

namespace Controller;

use Core\Controller;
use Model\Task;
use Core\Router;
use Core\View;
use Libs\Message;

class TaskController extends Controller
{
    public function actionIndex(){}

    /**
     * Create task function
     */
    public function actionCreate()
    {
        $projectId = filter_input(INPUT_POST, 'project-id', FILTER_VALIDATE_INT);
        $task = filter_input(INPUT_POST, 'task');

        if ($projectId && $task) {
            if (Router::isAjax()) {
                $response = [];
                $response['project-id'] = $projectId;
                $model = new Task();
                $model->name = $task;
                $model->projectId = $projectId;
                $model->sortOrder = $model->getSortOrder();

                if ($model->validate() && $id = $model->save()) {
                    $response['status'] = true;
                    $response['task_block'] = View::renderPartial('partial/task', [
                        'task' => [
                            'id' => $id,
                            'name' => $model->name,
                            'priority_name' => 'Not Urgent & Not Important',
                            'priority_color' => 'gray'
                        ],
                    ]);
                } else {
                    $response['status'] = false;
                    $response['message'] = Message::hasMessages() ? Message::getLastMessage() : null;
                }
                echo json_encode($response);
                return;
            }
        }
    }

    /**
     * Delete task function
     */
    public function actionDelete()
    {
        $taskId = filter_input(INPUT_POST, 'task-id', FILTER_VALIDATE_INT);

        if ($taskId) {
            if (Router::isAjax()) {
                $response['task_id'] = $taskId;
                $model = new Task();
                $model->findTaskById($taskId);
                $response['status'] = $model->delete() ? true : false;
                echo json_encode($response);
                return;
            }
        }
    }

    /**
     * Sort task function
     */
    public function actionSort()
    {
        $order = filter_input(INPUT_POST, 'order', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
        if (count($order) > 0) {
            if (Router::isAjax()) {
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

    /**
     * Update task function
     */
    public function actionUpdate()
    {
        $taskId = filter_input(INPUT_POST, 'task-id', FILTER_VALIDATE_INT);
        $newName = filter_input(INPUT_POST, 'new-name');

        if ($taskId && $newName) {
            if (Router::isAjax()) {
                $response = [];
                $response['task-id'] = $taskId;
                $model = new Task();
                $model->findTaskById($taskId);
                $model->name = $newName;
                if ($model->validate() && $id = $model->update()) {
                    $response['status'] = true;
                } else {
                    $response['status'] = false;
                    $response['message'] = Message::hasMessages() ? Message::getLastMessage() : null;
                }
                echo json_encode($response);
                return;
            }
        }
    }

    /**
     * Change priority task function
     */
    public function actionChangePriority()
    {
        $taskId = filter_input(INPUT_POST, 'task-id', FILTER_VALIDATE_INT);

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
                } else {
                    $response['status'] = false;
                }
                echo json_encode($response);
                return;
            }
        }
    }

    /**
     * Change task deadline
     */
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
                $response['status'] = $model->changeDeadline($deadline) ? true : false;
                echo json_encode($response);
                return;
            }
        }
    }

    /**
     * Check task
     */
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
                $response['status'] = $model->changeDone($isDone) ? true : false;
                echo json_encode($response);
                return;
            }
        }
    }
}