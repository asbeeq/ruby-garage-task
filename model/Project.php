<?php

namespace Model;

use Core\Model;

class Project extends Model
{
    public $name;
    public $userId;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'projects';
    }

    public function validate()
    {

    }

    public function save()
    {

    }

    public function update()
    {

    }

    public function hasProject()
    {
        $id = $_SESSION['user_id'];
        if ($id) {
            $query = "SELECT * FROM " . $this->table . " WHERE user_id = " . $id;
            return $this->mysqli->query($query);
        }
    }

    public function getUserProjects($userId)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = " . $userId;
        $result = $this->mysqli->query($query);
        $projects = [];
        while ($row = $result->fetch_assoc()) {
            $projects[] = $row;
        }
        return $projects;
    }
}