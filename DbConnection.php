<?php
/**
 * Created by IntelliJ IDEA.
 * User: augustas
 * Date: 2018-08-09
 * Time: 15:05
 */

class DbConnection
{
    private $connection;
    private static $instance;

    public static function GetInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct()
    {
        $config = parse_ini_file('./private/config.ini');
        $this->connection = mysqli_connect($config['servername'], $config['username'], $config['password'], $config['dbname']) or die("Couldn't connect");

        if ($this->connection === false) {
            return mysqli_connect_error();
        }
    }

    // Get mysqli connection
    public function getConnection() {
        return $this->connection;
    }
}