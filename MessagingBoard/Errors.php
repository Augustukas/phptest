<?php


namespace MessagingBoard;


class Errors
{
    private $errors = [];
    /**
     * Errors constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }


}