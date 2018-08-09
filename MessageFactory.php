<?php
/**
 * Created by IntelliJ IDEA.
 * User: augustas
 * Date: 2018-08-09
 * Time: 19:17
 */

class MessageFactory
{
    public static function createFromDbResponse($row)
    {
        $message = new Message();
        $message
            ->setFullname($row['fullname'])
            ->setBirthday($row['birthday'])
            ->setEmail($row['email'])
            ->setMessage($row['message'])
            ->setMessageTime($row['messageTime']);
        return $message;
    }
}