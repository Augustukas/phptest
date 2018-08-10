<?php

namespace MessagingBoard;



use DbConnection;
use Message;
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

    /**
     * @param Message $message
     * @return boolean success
     */
    public function saveMessage($message){

        $sql = "INSERT INTO messagingboard.messages (fullname, birthday, email, message, messageTime)  values (?, ?, ?, ?, FROM_UNIXTIME(?))";
        $statement = self::$connection->prepare($sql);
        $msgPropertyArray = $message->toArray();
        $statement->bind_param('sssss',
            $msgPropertyArray['fullname'],
            $msgPropertyArray['birthday'],
            $msgPropertyArray['email'],
            $msgPropertyArray['message'],
            $msgPropertyArray['messageTime']);
        $execute = $statement->execute();

        if ($execute === TRUE) {
            echo "Sukurta sėkmingai";
        } else {
            echo "Error: " . $sql . "<br>" . $statement->error;
        }
        $statement->close();
        return $execute;
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