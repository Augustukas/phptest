<?php
namespace MessagingBoard;

interface MessageInterface {

    function setFullname($fullname);
    function setBirthday($birthday);
    function setEmail($email);
    function setMessage($message);
    function setMessageTime($messageTime);

}