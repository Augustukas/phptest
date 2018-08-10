<?php

class Message
{
    private $fullname;
    private $birthday;
    private $email;
    private $message;
    private $messageTime;

    public function __construct()
    {
        $this->messageTime = time();
    }

    /**
     * @return int
     */
    public function getMessageTime()
    {
        return $this->messageTime;
    }


    /**
     * @return mixed
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param mixed $fullname
     * @return Message
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;

    }

    /**
     * @param mixed $birthday
     * @return Message
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return Message
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param int $messageTime
     */
    public function setMessageTime($messageTime)
    {
        $this->messageTime = $messageTime;
    }

    public function calculatePersonAge()
    {
        $dateTime1 = new DateTime($this->getBirthday());
        $dateTime2 = new DateTime();

        $years = $dateTime1->diff($dateTime2);
        return $years->y . ' m.';
    }

    public function toArray()
    {
        return [
            'fullname' => $this->fullname,
            'birthday' => $this->birthday,
            'email' => $this->email,
            'message' => $this->message,
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function saveInDb()
    {
        $instance = DbConnection::getInstance();

        /** @var mysqli $connection */
        $connection = $instance->getConnection();

        $sql = "INSERT INTO messages (fullname, birthday, email, message, messageTime)  values (?, ?, ?, ?, FROM_UNIXTIME(?))";
        $statement = $connection->prepare($sql);
        $statement->bind_param('sssss', $this->fullname, $this->birthday, $this->email, $this->message, $this->messageTime);
        $execute = $statement->execute();

        if ($execute === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $statement->error;
        }
        $statement->close();
        return $execute;
    }


}