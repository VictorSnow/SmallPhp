<?php
namespace Xend\Model;

class Record
{
    public $_pk;
    public $_tableName = __CLASS__;
    public $_attributes = array();
    public $_values = array();

    public function __construct($attributes = array())
    {
        foreach ($attributes as $key => $value)
        {
            $this->{$key} = $value;
        }
    }

    public static function model()
    {
        return new static();
    }

    public function __set($name, $value)
    {
        if (in_array($name, $this->_attributes))
        {
            $this->_values[$name] = $value;
        }
    }

    public function __get($name)
    {
        if(isset($this->_values[$name]))
        {
            return $this->_values[$name];
        }
        return null;
    }

    public function get($pk)
    {
        return $this->find("{$this->_pk} = :pk", array(':pk' => $pk));
    }

    public function save()
    {
        $pk = $this->_values[$this->_pk];
        $model = $this->get($pk);
        if($model)
        {
            $this->update();
        }
        else
        {
            $this->insert();
        }
    }

    /**
     * @param $where
     * @param $params
     * @return static
     */
    public function count($where, $params)
    {
        $sql = "select count(1) as total from {$this->_tableName} where {$where}";
        $resultSet = $this->getDb()->query($sql, $params);
        return $resultSet ? ($resultSet[0]['total']) : 0;
    }

    public function find($where, $params)
    {
        $sql = "select *  from {$this->_tableName} where {$where} limit 1";
        $resultSet = $this->getDb()->query($sql, $params);
        if($resultSet)
        {
            return new static($resultSet[0]);
        }
        return null;
    }

    public function insert()
    {
        $tkeys = $tvalues = '';
        $bindParams = array();

        foreach ($this->_values as $key => $value)
        {
            $tkeys .= $key.',';
            $tvalues .= ':'.$key. ',';
            $bindParams[':'.$key] = $value;
        }

        $tkeys = trim($tkeys, ',');
        $tvalues = trim($tvalues, ',');

        $sql = "insert into {$this->_tableName} ({$tkeys}) values({$tvalues})";
        return $this->getDb()->exec($sql, $bindParams);
    }

    public function update()
    {
        $bindParams = array();
        $colomnSets = '';

        foreach ($this->_values as $key => $value)
        {
            $colomnSets .= $key.'=:'.$key. ',';
            $bindParams[':'.$key] = $value;
        }

        $colomnSets = trim($colomnSets, ',');
        $bindParams[':pk'] = $this->_values[$this->_pk];
        $sql = "update {$this->_tableName} set {$colomnSets} where {$this->_pk} = :pk";
        return $this->getDb()->exec($sql, $bindParams);
    }

    public function insertOrUpdate()
    {
        $tkeys = $tvalues = '';
        $colomnSets = '';
        $bindParams = array();

        foreach ($this->_values as $key => $value)
        {
            $tkeys .= $key.',';
            $tvalues .= ':'.$key. ',';

            if($key != $this->_pk)
            {
                $colomnSets .= $key.'=:'.$key. ',';
            }

            $bindParams[':'.$key] = $value;
        }

        $tkeys = trim($tkeys, ',');
        $tvalues = trim($tvalues, ',');
        $colomnSets = trim($colomnSets, ',');

        $sql = "insert into {$this->_tableName}({$tkeys}) values ({$tvalues}) ON DUPLICATE KEY UPDATE {$colomnSets}";
        return $this->getDb()->exec($sql, $bindParams);
    }

    public function getDb()
    {
        return \Xend\Application::getInstant()->db;
    }
}