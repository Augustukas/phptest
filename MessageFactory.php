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

    /**
     * @param Message $message
     * @param $post
     * @return array
     */
    public static function createFromPost($message, $post)
    {
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
        return $errors;
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