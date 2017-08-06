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
        $user = $this->findUserByLogin()->fetch_assoc();
        if (password_verify($this->password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_login'] = $user['login'];
            return true;
        }
        return false;
    }

    public static function isLogin()
    {
        if (isset($_SESSION['user_id'])) {
            return true;
        }
        return false;
    }

    public static function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_login']);
    }

    private function checkLogin()
    {
        return $this->findUserByLogin()->num_rows;
    }

    private function findUserByLogin()
    {
        $query = "SELECT * FROM `users` WHERE login LIKE '" . $this->login . "' LIMIT 1";
        return $this->mysqli->query($query);
    }
}