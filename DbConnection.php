<?php
/**
 * Created by IntelliJ IDEA.
 * User: augustas
 * Date: 2018-08-09
 * Time: 15:05
 */

class DbConnection
{
    public static function Instance()
    {
        static $connection = null;
        if ($connection === null) {
            $connection = new DbConnection();
        }
        return $connection;
    }

    private function __construct()
    {
        $config = parse_ini_file('./private/config.ini');
        $connection = mysqli_connect($config['servername'], $config['username'], $config['password'], $config['dbname']);

        if ($connection === false) {
            return mysqli_connect_error();
        }
        echo 'success';
        return $connection;
    }

}