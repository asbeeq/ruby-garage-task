<?php

namespace Model;

use Core\Model;

class Task extends Model
{
    public $id;
    public $name;
    public $priority;
    public $isDone = 0;
    public $projectId;
    public $deadline = 'NULL';

    function __construct()
    {
        parent::__construct();
        $this->table = 'tasks';
    }

    public function getPriority()
    {
        $query = "SELECT priority FROM " . $this->table .
            " WHERE project_id = " . $this->projectId . " ORDER BY id DESC LIMIT 1";
        return $this->mysqli->query($query)->fetch_assoc()['priority'] + 1;
    }

    public function save()
    {
        $query = "INSERT INTO " . $this->table . " (name, priority, is_done, project_id, deadline) " .
            "VALUES ('" .
            $this->name . "', " .
            $this->priority . ", " .
            $this->isDone . ", " .
            $this->projectId. ", " .
            $this->deadline. ");";
        return $this->mysqli->query($query) ? $this->mysqli->insert_id : false;
    }

    public function getTasks($projectId)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE project_id = " . $projectId;
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
}