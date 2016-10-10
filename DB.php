<?php

/**
 * Created by PhpStorm.
 * User: coolmobile
 * Date: 10/10/16
 * Time: 15:49
 */
class DB
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $connection;

    /**
     * DB constructor.
     * @param $servername
     * @param $username
     * @param $password
     * @param $dbname
     */
    public function __construct($servername, $username, $password, $dbname)
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->connection = new mysqli($servername, $username, $password, $dbname);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }

    }

    public function select($query){
        return $this->connection->query($query);
    }

}