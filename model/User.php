<?php

namespace Model;

use Core\Model;
use Core\Message;

class User extends Model
{

    public $login;
    public $password;
    public $passwordConfirm;

    public $message = [];


    public function validate() {

        $hasError = false;

        if (!$this->login) {
            Message::Error('Login can not be empty');
            $hasError = true;
        }

        if (!$this->password) {
            Message::Error('Password can not be empty');
            $hasError = true;
        }

        if (!$this->passwordConfirm) {
            Message::Error('Password confirm can not be empty');
            $hasError = true;
        }

        if ($this->password && $this->passwordConfirm && $this->password !== $this->passwordConfirm) {
            Message::Error('Passwords do not match');
            $hasError = true;
        }

        if (!$hasError && $this->checkLogin()) {
            Message::Error('Login already exists');
            $hasError = true;
        }

        return $hasError ? false : true;
    }

    public function save()
    {
        $query = "INSERT INTO users (login, password_hash) VALUES ('" . $this->login . "', '" . password_hash($this->password, PASSWORD_DEFAULT) . "');";
        return $this->mysqli->query($query);
    }

    public function login()
    {

    }

    public function isLogin()
    {

    }

    private function checkLogin()
    {
        $query = "SELECT * FROM `users` WHERE login LIKE '" . $this->login . "' LIMIT 1";
        return $this->mysqli->query($query)->num_rows;
    }
}