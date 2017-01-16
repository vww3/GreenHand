<?php
namespace System\Core;

use PDO;

/**
 * MySQL main class. This class allows to manipulate SQL databases easily in an organize way.
 * This class use PDO technology.
 * If a model has to use database, it must extend this class.
 *
 * @package IRON
 * @link ... nothing yet...
 * @author Mickaël Boidin <mickael.boidin@icloud.com>
 */
class Mysql
{
	
    /**
     * List of PDO instances. Each instance is connected to one database.
     * It allows us to use multiple time a same PDO object without create
     * an memory-eater new object.
     * 
     * @var array
     * @access private
     * @static
     */
    private static $_databases = [];
       
    /**
     * The identifier of the PDO object used by the current Mysql object.
     * the PDO object is self::$_databases[self::$_actualDatabase].
     * 
     * @var var
     * @access private
     */
    private $_actualDatabase;
    
    /**
     * The database table name that manage this Mysql object (one object for one table)
     * 
     * @var string
     * @access private
     */
    private $_table;
    
    /**
     * the primaryKey of the table of the current Mysql object (please be "id").
     * 
     * @var string
     * @access private
     */
    private $_primaryKey = 'id';
    
    /**
     * List of executed SQL queries (for debug purpose).
     * 
     * @var array
     * @access private
     */
    private $_queries = [];

    /**
     * Constructor of the class. Initialize the PDO object if doesn't exist
     * and use it.
     * 
     * @access public
     * @param string $table The name of the table that manage this object
     * @param string $database The name of the database we connected
     * @param string $host The host of the database
     * @param string $login The login of the database
     * @param string $password The password of the database
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
	    //database identifier is always "host@database"
	    //example: localhost@mySuperDB
	    $this->_actualDatabase = $host.'@'.$database;
	    
	    if (empty(self::$_databases[$this->_actualDatabase])) {
		    //we want a PDo object that return object from queries and use UTF-8
		    //we also use Exception if errors
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
     * Get the name of the table of the current Mysql object
     * 
     * @access public
     * @return string
     */
    public function table()
    {
	    return $this->_table;
    }
    
    /**
     * Get the primary key name of the current table of the Mysql object
     * 
     * @access public
     * @return string
     */
    public function primary()
    {
	    return $this->_primaryKey;
    }

    /**
     * Excution of SQL query on the current database. Queries can be prepared or not.
     * 
     * @access protected
     * @param string $sql The query
     * @param array $preparation the array of additional informations for preparing the query
     * @return PDOQueryStatement
     */
    protected function query($sql, $preparation = [])
    {   
        $query = self::$_databases[$this->_actualDatabase]->prepare($sql);
        $query->execute($preparation);
        
        $this->_queries[] = $query;

        return $query;    
    }
    
    /**
     * Select queries builder.
     * 
     * @access protected
     * @param mixed $selection Array or String of selected column
     * @param mixed $parameters It can be a :
     *     - string -> where condition
     *     - array -> multiple parameters like where, join, group by, order by or limit
     * @param array $preparation the array of additional informations for preparing the query
     * @return PDOQueryStatement
     */
    public function select($selection = '*', $parameters = [], $preparation = [])
    {
	    //if the select var is an array, we implode it with ", "
	    $select = is_array($selection) ?
	    	implode(', ', $selection) :
	    	$selection;
	    	
	    $sql = 'SELECT '.$select.' FROM '.$this->_table;
	    
	    //if parameters is a string this is a where
	    if(!is_array($parameters))
	    	$sql .= ' WHERE '.$parameters;
	    
	    //JOIN
	    if(!empty($parameters['join'])) {
	    	$sql .= ', ';
	    	$sql .= is_array($parameters['join']) ? 
	    		implode(', ', $parameters['join']) : 
	    		$parameters['join'];
	    }
	    
	    if(!empty($parameters['left'])) {
	    	foreach($parameters['left'] as $join => $on) {
		    	$sql .= is_array($on) ? 
		    		' LEFT JOIN '.$join.' ON '.implode(' AND ', $on) :
		    		' LEFT JOIN '.$join.' ON '.$on;
	    	}
	    }
	    
	    if(!empty($parameters['right'])) {
	    	foreach($parameters['right'] as $join => $on) {
		    	$sql .= is_array($on) ? 
		    		' RIGHT JOIN '.$join.' ON '.implode(' AND ', $on) :
		    		' RIGHT JOIN '.$join.' ON '.$on;
	    	}
	    }
	    
	    //WHERE (array imploded with " AND ")
	    if(!empty($parameters['where'])) {
		    $sql .= ' WHERE ';
	    	$sql .= is_array($parameters['where']) ? 
	    		implode(' AND ', $parameters['where']) : 
	    		$parameters['where'];
	    }
	    //GROUP BY
	    if(!empty($parameters['group'])) { 
	    	$sql .= ' GROUP BY '.$parameters['group'];
	    }
	    //ORDER BY
	    if(!empty($parameters['order'])) {
	    	$sql .= ' ORDER BY '.$parameters['order'];
	    }
	    //LIMIT
	    if(!empty($parameters['limit'])) {
	    	$sql .= ' LIMIT '.$parameters['limit'];
	    }

	    return $this->query($sql, $preparation);
    }
	
	/**
     * Select query executionner -> multiple results
     * 
     * @access protected
     * @param mixed $selection Array or String of selected column
     * @param mixed $parameters It can be a :
     *     - string -> where condition
     *     - array -> multiple parameters like where, join, group by, order by or limit
     * @param array $preparation the array of additional informations for preparing the query
     * @return array
     */
    public function all($selection = '*', $parameters = [], $preparation = [])
    {    
        return $this->select($selection, $parameters, $preparation)->fetchAll();    
    }
    
    /**
     * Select query executionner -> one result
     * 
     * @access protected
     * @param mixed $selection Array or String of selected column
     * @param mixed $parameters It can be a :
     *     - string -> where condition
     *     - array -> multiple parameters like where, join, group by, order by or limit
     * @param array $preparation the array of additional informations for preparing the query
     * @return stdObject
     */
    public function one($selection = '*', $parameters = [], $preparation = [])
    {    
        return $this->select($selection, $parameters, $preparation)->fetch();    
    }

    /**
     * Select query executionner -> the X first results
     * 
     * @access protected
     * @param int $offset Number of needed results
     * @param mixed $selection Array or String of selected column
     * @return array
     */
    public function first($offset, $selection = '*')
    {
	    $select = is_array($selection) ? implode(', ', $selection) : $selection;
	    $parameters = ['order' => $this->_primaryKey.' ASC', 'limit' => $offset];
	    
        return $this->all($select, $parameters);    
    }

    /**
     * Select query executionner -> the X last results
     * 
     * @access protected
     * @param int $offset Number of needed results
     * @param mixed $selection Array or String of selected column
     * @return array
     */
    public function last($offset, $selection = '*')
    {    
        $select = is_array($selection) ? implode(', ', $selection) : $selection;
	    $parameters = ['order' => $this->_primaryKey.' DESC', 'limit' => $offset];
	    
        return $this->all($select, $parameters);     
    }

    /**
     * Save and Update informations in database. Can be an UPDATE or an INSERT query.
     * The nature of the query depend on the presence of the primary key.
     * If a primary key is entered this is an UPDATE.
     * 
     * @access public
     * @param array $data Array of datas we need to store in database. the keys of the array
     *                    must be same as columns of the table in database
     * @return void
     */
    public function save($data)
    {
	    //here we have a primary key
        if (!empty($data[$this->_primaryKey])) {
			//we build the query with the key of the array, the data will be in the preparation
			$keys = [];
			foreach (array_keys($data) as $index => $key)
				if ($key != $this->_primaryKey)
					$keys[$index] = $key.'=:'.$key;
            $updates = implode(', ', $keys);
                               
            $sql = "UPDATE $this->_table SET $updates WHERE $this->_primaryKey=:$this->_primaryKey";

            return $this->query($sql, $data);
        
        //here we don't have a primary key  
        } else {
            //same logic than UPDATE (but easer)
            $keys = implode(', ', array_keys($data));
            $values = ':'.implode(', :', array_keys($data));
            
            $sql = "INSERT INTO $this->_table ($keys) VALUES ($values)";
                        
            return $this->query($sql, $data) ? self::$_databases[$this->_actualDatabase]->lastInsertId() : false;
        
        }
    }

    /**
     * Delete query builder.
     * 
     * @access public
     * @param mixed $primaryKey The primary key of the entry to remove
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
     * truncate query builder.
     * 
     * @access public
     * @return void
     */
    public function truncate()
    {    
        $this->query("TRUNCATE $this->_table");    
    }

    /**
     * Verify if there are results that fit the condition.
     * 
     * @access public
     * @param string $condition Where condition use for the test
     * @param $preparation
     * @return int
     */
    public function exist($condition, $preparation = [])
    {    
        $test = $this->all($this->_primaryKey, ['where' => $condition], $preparation);
        
        return empty($test) ? false : sizeof($test);
    }
    
    /**
     * Return the number for entries in the table of current Mysql object.
     * 
     * @access public
     * @return int
     */
    public function size()
    {    
        return $this->one('COUNT(*) AS size')->size;    
    }
    
    /**
     * Verify if the table exist.
     * 
     * @access public
     * @return bool
     */	  
    public function didTableExist()
    {
	    $test = $this->query("SHOW TABLES LIKE :table", ['table' => $this->_table])->fetch();
	    return !empty($test); 
    }

    /**
     * Destructor function. Remove the connexions.
     * 
     * @access public
     * @return void
     */
    public function __destruct()
    {    
        self::$_databases = null;
    }
}
