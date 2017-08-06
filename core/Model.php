<?php

namespace Core;

abstract class Model
{
    public $mysqli;

    function __construct()
    {
        $this->mysqli = include CONFIG_PATH . 'database.php';
    }

    function __destruct()
    {
        $this->mysqli->close();
    }
}