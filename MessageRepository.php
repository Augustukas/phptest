<?php

namespace MessagingBoard;



use DbConnection;
use MessageFactory;

class MessageRepository
{
    private static $connection;
    private static $instance;

    public function __construct()
    {

        self::$instance = DbConnection::getInstance();
        /** @var \DbConnection $instance */
        self::$connection = self::$instance->getConnection();

    }

    public function getMessageCount()
    {
        $result = self::$connection->query("SELECT COUNT(*) as total FROM messagingboard.messages ORDER BY  messageTime");
        $row = $result->fetch_row();
        return $row[0];
    }

    public function getAllMesages() {
        $messages = [];
        $result = self::$connection->query("SELECT * FROM messagingboard.messages ORDER BY  messageTime desc");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $message = MessageFactory::createFromDbResponse($row);
                $messages[] = $message;
            }
        }
        return $messages;
    }

    public function saveMessage($message){

    }

    public function getLimitedMessages($limit, $page)
    {
        $messages = [];
        $result = self::$connection->query("SELECT * FROM messagingboard.messages ORDER BY  messageTime desc LIMIT "
            . ( ( $page - 1 ) * $limit ) . ", ".$limit);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $message = MessageFactory::createFromDbResponse($row);
                $messages[] = $message;
            }
        }
        return $messages;
    }
}