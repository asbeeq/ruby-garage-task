<?php

namespace Model;

use Core\Model;

class Task extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->table = 'tasks';
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
}