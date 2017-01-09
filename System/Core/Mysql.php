<?php
namespace System\Core;

use PDO;

/**
 * Mysql class.
 */
class Mysql
{
	
    /**
     * _databases
     * 
     * (default value: [])
     * 
     * @var mixed
     * @access private
     * @static
     */
    private static $_databases = [];
       
    /**
     * _actualDatabase
     * 
     * @var mixed
     * @access private
     */
    private $_actualDatabase;
    
    /**
     * table
     * 
     * @var mixed
     * @access private
     */
    private $_table;
    
    /**
     * primaryKey
     * 
     * (default value: 'id')
     * 
     * @var string
     * @access private
     */
    private $_primaryKey = 'id';
    
    /**
     * queries
     * 
     * @var mixed
     * @access private
     */
    private $_queries = [];

    /**
     * __construct function.
     * 
     * @access public
     * @param $table
     * @param $database (default: MYSQL_BDD)
     * @param $host (default: MYSQL_HEBERGEUR)
     * @param $login (default: MYSQL_LOGIN)
     * @param $password (default: MYSQL_MDP)
     * @return void
     */
    public function __construct(
	    $table,
        $database = MYSQL_DATABASE,
        $host = MYSQL_HOST,
        $login = MYSQL_LOGIN,
        $password = MYSQL_PASSWORD
    ) {
	    $this->_table = $table;
	    $this->_actualDatabase = $host.'@'.$database;
	    
	    if (empty(self::$_databases[$this->_actualDatabase])) {
		    self::$_databases[$this->_actualDatabase] = new PDO(
	            "mysql:host=".$host.";dbname=".$database, $login, $password,
	            [
	                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
	                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
	            ]
	        );
	    }
    }
    
    /**
     * table function.
     * 
     * @access public
     * @return string
     */
    public function table()
    {
	    return $this->_table;
    }
    
    /**
     * primary function.
     * 
     * @access public
     * @return string
     */
    public function primary()
    {
	    return $this->_primaryKey;
    }

    /**
     * query function.
     * 
     * @access protected
     * @param $sql
     * @param $preparation (default: [])
     * @return void
     */
    protected function query($sql, $preparation = [])
    {    
        $query = self::$_databases[$this->_actualDatabase]->prepare($sql);
        $query->execute($preparation);
        
        $this->_queries[] = $query;
        
        return $query;    
    }
    
    public function select($selection = '*', $parameters = [], $preparation = [])
    {   
	    $select = is_array($selection) ?
	    	implode(', ', $selection) :
	    	$selection;
	    	
	    $sql = 'SELECT '.$select.' FROM '.$this->_table;
	    
	    if(!is_array($parameters))
	    	$sql .= ' WHERE '.$parameters;
	    
	    if(!empty($parameters['join'])) {
	    	$sql .= is_array($parameters['join']) ? 
	    		', '.implode(', ', $parameters['join']) : 
	    		', '.$parameters['join'];
	    }
	    if(!empty($parameters['where'])) {
	    	$sql .= is_array($parameters['where']) ? 
	    		' WHERE '.implode(' AND ', $parameters['where']) : 
	    		' WHERE '.$parameters['where'];
	    }
	    if(!empty($parameters['group'])) { 
	    	$sql .= ' GROUP BY '.$parameters['group'];
	    }
	    if(!empty($parameters['order'])) {
	    	$sql .= ' ORDER BY '.$parameters['order'];
	    }
	    if(!empty($parameters['limit'])) {
	    	$sql .= ' LIMIT '.$parameters['limit'];
	    }

	    return $this->query($sql, $preparation);
    }

    public function all($selection = '*', $parameters = [], $preparation = [])
    {    
        return $this->select($selection, $parameters, $preparation)->fetchAll();    
    }
    
    public function one($selection = '*', $parameters = [], $preparation = [])
    {    
        return $this->select($selection, $parameters, $preparation)->fetch();    
    }

    /**
     * first function.
     * 
     * @access public
     * @param $offset
     * @return void
     */
    public function first($offset, $selection = '*')
    {
	    $select = is_array($selection) ? implode(', ', $selection) : $selection;
	    $parameters = ['order' => $this->_primaryKey.' ASC', 'limit' => $offset];
	    
        return $this->all($select, $parameters);    
    }

    /**
     * last function.
     * 
     * @access public
     * @param $offset
     * @return void
     */
    public function last($offset, $selection = '*')
    {    
        $select = is_array($selection) ? implode(', ', $selection) : $selection;
	    $parameters = ['order' => $this->_primaryKey.' DESC', 'limit' => $offset];
	    
        return $this->all($select, $parameters);     
    }

    /**
     * save function.
     * 
     * @access public
     * @param $data
     * @return void
     */
    public function save($data)
    {
        if (!empty($data[$this->_primaryKey])) {
			
			$keys = [];
			foreach (array_keys($data) as $index => $key)
				if ($key != $this->_primaryKey)
					$keys[$index] = $key.'=:'.$key;
            $updates = implode(', ', $keys);
                               
            $sql = "UPDATE $this->_table SET $updates WHERE $this->_primaryKey=:$this->_primaryKey";

            return $this->query($sql, $data);
            
        } else {
            
            $keys = implode(', ', array_keys($data));
            $values = ':'.implode(', :', array_keys($data));
            
            $sql = "INSERT INTO $this->_table ($keys) VALUES ($values)";
                        
            return $this->query($sql, $data) ? self::$_databases[$this->_actualDatabase]->lastInsertId() : false;
        
        }
    }

    /**
     * remove function.
     * 
     * @access public
     * @param $primaryKey
     * @return void
     */
    public function remove($primaryKey)
    {
        return $this->query(
            "DELETE FROM $this->_table WHERE $this->_primaryKey=:$this->_primaryKey",
            [$this->_primaryKey => $primaryKey]
        );    
    }
    
    /**
     * removeAll function.
     * 
     * @access public
     * @return void
     */
    public function removeAll()
    {    
        $this->query("TRUNCATE $this->_table");    
    }

    /**
     * exist function.
     * 
     * @access public
     * @param mixed $condition
     * @param $preparation
     * @return void
     */
    public function exist($condition, $preparation = [])
    {    
        $test = $this->all($this->_primaryKey, ['where' => $condition], $preparation);
        
        return empty($test) ? false : true;
    }
    
    /**
     * size function.
     * 
     * @access public
     * @return void
     */
    public function size()
    {    
        $get = $this->one('COUNT(*) AS size');

        return !empty($get) ? $get->size : false;    
    }
    
    public function didTableExist()
    {
	    $test = $this->query("SHOW TABLES LIKE :table", ['table' => $this->_table])->fetch();
	    return !empty($test); 
    }

    /**
     * __destruct function.
     * 
     * @access public
     * @return void
     */
    public function __destruct()
    {    
        self::$_databases = null;
    }
}
