<?php

namespace Model;

use Core\Model;
use Libs\Message;

class Project extends Model
{
    public $id;
    public $name;
    public $userId;

    public function __construct()
    {
        parent::__construct();
        $this->table = 'projects';
    }

    public function getUserProjects($userId)
    {
        if ($userId) {
            $query = "SELECT * FROM " . $this->table . " WHERE user_id = " . $userId;
            $result = $this->mysqli->query($query);
            $projects = [];
            while ($row = $result->fetch_assoc()) {
                $projects[] = $row;
            }
            return $projects;
        }
        return false;
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

        if (!$this->userId) {
            Message::Error('You did not enter');
            $hasError = true;
        }

        return $hasError ? false : true;
    }

    public function save()
    {
        $query = "INSERT INTO " . $this->table . " (name, user_id) VALUES ('" .
            $this->name . "', " . $this->userId . ");";
        return $this->mysqli->query($query);
    }

    public function findById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = " . $id . " LIMIT 1";
        $response = $this->mysqli->query($query)->fetch_assoc();
        $this->id = $response['id'];
        $this->name = $response['name'];
        $this->userId = $response['user_id'];
    }

    public function update($name)
    {
        $query = "UPDATE " . $this->table . " SET name = '" . $name . "' WHERE id = " . $this->id;
        return $this->mysqli->query($query);
    }

    public function delete()
    {
        $this->deleteProjectTasks();
        $query = "DELETE FROM " . $this->table . " WHERE id = " . $this->id;
        return $this->mysqli->query($query);
    }

    private function deleteProjectTasks()
    {
        $model = new Task();
        $model->deleteTasksFromProject($this->id);
    }
}