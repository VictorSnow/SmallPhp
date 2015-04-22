<?php
/**
 * Created by PhpStorm.
 * User: xulei
 * Date: 2015/4/22
 * Time: 16:42
 */

namespace Xend\Db;


class Db {

    private $db = null;

    public function __construct($config)
    {
        $host = $config['host'];
        $dbname = $config['dbname'];
        $username = $config['username'];
        $password = $config['password'];

        $this->db = new \PDO("mysql:host=$host;dbname=$dbname",$username,$password,array(
            \PDO::ATTR_PERSISTENT => true,
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ));
    }

    public function getDb()
    {
        return $this->db;
    }

    public function query($sql,$binds = array())
    {
        $stmt = $this->db->prepare($sql);

        foreach($binds as $key => $value)
        {
            $stmt->bindParam($key,$value);
        }
        $stmt->execute();

        $resultSet = array();
        while($row = $stmt->fetch(\PDO::FETCH_ASSOC))
        {
            $resultSet[] = $row;
        }
        return $resultSet;
    }
} 