<?php

namespace Core;


class Message
{

    public static $messages = [];

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
        self::$messages[] = [
            'text' => $message,
            'type' => $type,
        ];
    }

    public static function setMessages(array $messages)
    {
        self::$messages = $messages;
    }

    public static function getMessages()
    {
        return self::$messages;
    }

    public static function getLastMessage()
    {
        return array_pop(self::$messages);
    }

    public static function hasMessages()
    {
        if (count(self::$messages) > 0 ) {
            return true;
        }
        return false;
    }

}