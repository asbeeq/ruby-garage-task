<?php

namespace Libs;


class Message
{

    public static function Error($message)
    {
        self::addMessage($message, MSG_ERROR);
    }

    public static function Success($message)
    {
        self::addMessage($message, MSG_SUCCESS);
    }

    public static function Info($message)
    {
        self::addMessage($message, MSG_INFO);
    }

    private static function addMessage($message, $type)
    {
        $_SESSION['messages'][] = [
            'text' => $message,
            'type' => $type,
        ];
    }

    public static function getMessages()
    {
        $msg = $_SESSION['messages'];
        unset($_SESSION['messages']);
        return $msg;
    }

    public static function hasMessages()
    {
        if (isset($_SESSION['messages'])) {
            return true;
        }
        return false;
    }

}