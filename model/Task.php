<?php

namespace Model;

use Core\Model;
use Libs\Message;

class Task extends Model
{
    public $id;
    public $name;
    public $sortOrder;
    public $priority = 1;
    public $isDone = 0;
    public $projectId;
    public $deadline = 'NULL';

    function __construct()
    {
        parent::__construct();
        $this->table = 'tasks';
    }

    public function validate()
    {
        $hasError = false;

        if (!$this->name) {
            Message::Error('Name can not be empty');
            $hasError = true;
        }

        if (strlen($this->name) > 255) {
            Message::Error('Name must be less than 255 characters');
            $hasError = true;
        }

        if (!$this->sortOrder) {
            Message::Error('Not set sort id');
            $hasError = true;
        }

        if (!is_int($this->sortOrder)) {
            Message::Error('Sort id must be integer');
            $hasError = true;
        }

        if (!$this->projectId) {
            Message::Error('Task not have project id');
            $hasError = true;
        }

        return $hasError ? false : true;
    }

    public function getSortOrder()
    {
        $query = "SELECT sort_order FROM " . $this->table .
            " WHERE project_id = " . $this->projectId . " ORDER BY id DESC LIMIT 1";
        return $this->mysqli->query($query)->fetch_assoc()['sort_order'] + 1;
    }

    public function save()
    {
        $query = "INSERT INTO " . $this->table . " (name, sort_order, priority_id, is_done, project_id, deadline) " .
            "VALUES ('" .
            $this->name . "', " .
            $this->sortOrder . ", " .
            $this->priority . ", " .
            $this->isDone . ", " .
            $this->projectId. ", " .
            $this->deadline. ");";
        return $this->mysqli->query($query) ? $this->mysqli->insert_id : false;
    }

    public function getTasks($projectId)
    {
        $query = "SELECT tasks.id, tasks.name, sort_order, priority_id, is_done, project_id, deadline, priorities.name as priority_name, color as priority_color FROM " .
            $this->table . " INNER JOIN priorities ON priority_id = priorities.id " .
            "WHERE project_id = " . $projectId . " ORDER BY sort_order ASC";
        $result = $this->mysqli->query($query);
        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
        return $tasks;
    }

    public function deleteTasksFromProject($projectId)
    {
        $query = "DELETE FROM " . $this->table . " WHERE project_id = " . $projectId;
        return $this->mysqli->query($query);
    }

    public function findTaskById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = " . $id . " LIMIT 1";
        $task = $this->mysqli->query($query)->fetch_assoc();
        if ($task) {
            $this->id = $task['id'];
            $this->name = $task['name'];
            $this->sortOrder = intval($task['sort_order']);
            $this->priority = intval($task['priority_id']);
            $this->projectId = intval($task['project_id']);
            $this->isDone = $task['is_done'];
            $this->deadline = $task['deadline'];
            return true;
        }
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = " . $this->id;
        return $this->mysqli->query($query);
    }

    public function sortOrder(array $ids)
    {
        $order = 1;
        foreach ($ids as $taskId) {
            $query = "UPDATE " . $this->table . " SET sort_order = " . $order . " WHERE id = " . $taskId;
            $this->mysqli->query($query);
            $order++;
        }
        return true;
    }

    public function update()
    {
        $query = "UPDATE " . $this->table . " SET name = '" . $this->name . "' WHERE id = " . $this->id;
        return $this->mysqli->query($query);
    }

    public function changePriority()
    {
        $model = new Priority();
        $priority = $model->getNextPriority($this->priority);
        $query = "UPDATE " . $this->table . " SET priority_id = " . $priority['id'] . " WHERE id = " . $this->id;
        $this->mysqli->query($query);
        return $priority;
    }

    public function changeDeadline($deadline)
    {
        $deadline = is_null($deadline) ? 'NULL' : "'" . $deadline . "'";
        $query = "UPDATE " . $this->table . " SET deadline = " . $deadline . " WHERE id = " . $this->id;
        return $this->mysqli->query($query);
    }

    public function changeDone($isDone)
    {
        $isDone = $isDone ? 1 : 0;
        $query = "UPDATE " . $this->table . " SET is_done = '" . $isDone . "' WHERE id = " . $this->id;
        return $this->mysqli->query($query);
    }
}