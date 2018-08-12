<?php

namespace MessagingBoard;

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

    /**
     * @param $post
     * @param \MessagingBoard\Errors $error
     * @return Message $message
     */
    public static function createFromPost($post, $error)
    {
        if(!$post) {
            $post = file_get_contents('php://input');
            $post = json_decode($post);
            $post = get_object_vars($post);
        }

        return Message::createFromPost($post, $error);
    }


}