<?php
use MessagingBoard\MessageInterface;

class Message implements MessageInterface
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
     * @param $post
     * @param \MessagingBoard\Errors $error
     * @return Message
     */
    public static function createFromPost($post, $error)
    {
        $message = new self();
        $errors = [];
        if (empty($post["fullname"])) {
            $errors['fullnameError'] = " privalomas laukas";
        } else {
            $message->setFullname(self::cleanUpInput($post["fullname"]));
            if (!preg_match("/^[a-zA-Z ]*$/", $message->getFullname())) {
                $errors['fullnameError'] = " leidžiamos tik raidės";
            }
            if (!(count(explode(' ', $message->getFullname())) == 2)) {
                $errors['fullnameError'] = " turi būti du žodžiai";
            }
        }

        if (empty($post["birthdate"])) {
            $errors['birthdateError'] = "privaloma užpildyti";
        } else {
            $message->setBirthday(self::cleanUpInput($post["birthdate"]));
            if (!self::validateDate($message->getBirthday())) {
                $errors['birthdateError'] = " netiksli, turi būti dabartyje ar Y-m-d ";
            }
        }

        if (empty($post["email"])) {
            //$emailError = "Paštas privalomas";
        } else {
            $message->setEmail(self::cleanUpInput($post["email"]));
            if (!filter_var($message->getEmail(), FILTER_VALIDATE_EMAIL)) {
                $errors['emailError'] = " blogas formatas";
            }
        }


        if (empty($post["message"])) {
            $message->setMessage("");
            $errors['messageError'] = " privaloma užpildyti";
        } else {
            $message->setMessage(self::cleanUpInput($post["message"]));
        }
        $error->setErrors($errors);
        return $message;
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
            'messageTime' => $this->messageTime,
        ];
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    private static function cleanUpInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    private static function validateDate($date, $format = 'Y-m-d')
    {
        $parsedDate = DateTime::createFromFormat($format, $date);
        $currentDate = new DateTime();
        return $currentDate > $parsedDate && $parsedDate && $parsedDate->format($format) === $date;
    }

}