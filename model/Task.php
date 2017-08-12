<?php

namespace Model;

use Core\Model;

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
        $query = "SELECT * FROM " . $this->table . " WHERE project_id = " . $projectId . " ORDER BY sort_order ASC";
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
            $this->sortOrder = $task['sort_order'];
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
}