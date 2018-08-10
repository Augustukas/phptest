<?php


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
        return Message::createFromPost($post, $error);
    }


}