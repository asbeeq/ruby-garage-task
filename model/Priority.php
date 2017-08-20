<?php

namespace Model;

use Core\Model;

class Priority extends Model
{
    public $prioritiesList = [];

    function __construct()
    {
        parent::__construct();
        $this->table = 'priorities';
        $this->getPrioritiesList();
    }

    public function getPrioritiesList()
    {
        $query = "SELECT * FROM " . $this->table;
        $result = $this->mysqli->query($query);
        while ($row = $result->fetch_assoc()) {
            $this->prioritiesList[] = $row;
        }
    }

    public function getNextPriority($currentPriority)
    {
        $nextId = [];
        while ($row = current($this->prioritiesList)) {
            if ($row['id'] == $currentPriority) {
                $nextId = next($this->prioritiesList);
                break;
            }
            next($this->prioritiesList);
        }

        if (!$nextId) {
            $nextId = reset($this->prioritiesList);
        }

        return $nextId;
    }
}