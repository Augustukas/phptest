<?php

namespace MessagingBoard;
class DbConnection
{
    private $connection;
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    protected function __construct()
    {
        $config = parse_ini_file('./private/config.ini');
        $this->connection = mysqli_connect($config['servername'], $config['username'], $config['password'], $config['dbname']) or die("Couldn't connect");

        if ($this->connection === false) {
            return mysqli_connect_error();
        }
        return true;
    }

    private function __clone()
    {
    }

    private function __wakeup()
    {
    }

    // Get mysqli connection
    public function getConnection()
    {
        return $this->connection;
    }
}