<?php

namespace Core;

abstract class Model
{
    public $mysqli;

    function __construct()
    {
        $this->mysqli = include BASE_PATH . '/app/database.php';
    }

    function __destruct()
    {
        $this->mysqli->close();
    }
}