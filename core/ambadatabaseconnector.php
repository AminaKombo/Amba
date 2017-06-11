<?php
/*
ambadatabaseconnector.php

Class AmbaDataConnector

connects to application's database

*/
namespace Amba\Core;
use PDO;

class AmbaDatabaseConnector{
    
    private $dbhost="localhost";
    
    private $dbname="";
    
    private $dbuser="root";
    
    private $dbpass;
    
    private $dbport=3306;
    
    private $CONNECTION;
    
    protected $PDO;//PHP Data Object
    
    public $hasConnectionError=false;
    
    public $connectionMade=false;
    
    /*
    @param mixed[] setupArray-> array of database values
    */
    public function __construct($setupArray){
        
        //define database connection fields from system constants
        
        $this->defineDatabaseAttributes($setupArray);
        
    }//constructor
    
    /*
    @param mixed[] setupArray -> array of datanase attributes
    */
    private function defineDatabaseAttributes($setupArray){
        
        foreach($setupArray as $key=>$val){
            
            $this->$key=$val;
            
        }//foreach
        
    }//defineDatabaseAttributes
    
    public function __destruct(){
        //destructor
    }//destructor
    
    /*
    established database connection, 
    returns error if something went wrong
    */
    public function openConnection(){
        
		$host_port=$this->getDBHost();
        
		$dbname=$this->getDBName();
        
		$db_port=$this->getDBPort();
        
        if(strlen($dbname)<1){
            
            return "Database name required."; 
            
            $this->hasConnectionError=true;
        
        }//if
        else{
            
            try{
                //attempt to make a connection
                $connPort=new PDO("mysql:host=$host_port;dbname=$dbname",
                                  $this->getDBUser(),
                                  $this->getDBPass(),
                                  array(PDO::ATTR_PERSISTENT => true)
                );

                //set the PDO
                $this->setPDO($connPort);

                //set the connection 
                $this->CONNECTION=$connPort;
                
                $this->hasConnectionError=false;
                
                $this->connectionMade=true;
                
                return "Connection established to ".$dbname;
                
            }//try
            catch(PDOException $e){
                
                $this->hasConnectionError=true;
                
                $this->connectionMade=false;
                
                //return an error message
                return $e->getMessage();

            }//catch
            
        }//else
        
	}//openConnection
    
    /*
    @param PDO pdo -> PHP Data Object for current instance
    */
	protected function setPDO($pdo){
        
		$this->PDO=$pdo;
        
	}//setPDO
    
    protected function unsetPDO(){
        
        $this->PDO=null;
        
    }//unsetPDO
    
    /*
    @param string query -> SQL query string with PDO '?' escapes
    @param mixed[] vals -> array with values to be used in query
    @return statement -> PDO prepared statement
    */
    public function executeQuery($query,$vals){//vals=array
        
        $this->openConnection();
        
		$statement=$this->PDO->prepare($query);
        
		$statement->execute($vals);
        
        $this->unsetPDO();
        
		return $statement;
        
	}//executeQuery
    
    /*
    @param string dbhost -> name of database host
    */
    private function setDBHost($dbhost){
        
        $this->dbhost=$dbhost;
        
    }//setDBHost
    
    public function getDBHost(){
        
        return $this->dbhost;
        
    }//getDBHost
    
    /*
    @param string dbname -> name of database
    */
    private function setDBName($dbname){
        
        $this->dbname=$dbname;
        
    }//setDBHost
    
    public function getDBName(){
        
       return $this->dbname;
    
    }//getDBName
    
    /*
    @param string dbuser -> database username
    */
    private function setDBUser($dbuser){
        
        $this->dbuser=$dbuser;
        
    }//setDBUser
    
    public function getDBUser(){
        
        return $this->dbuser;
        
    }//getDBUser
    
    /*
    @param string dbpass -> database user's password
    */
    private function setDBPass($dbpass){
        
       $this->dbpass=$dbpass; 
        
    }//setDBPass
    
    public function getDBPass(){
        
       return $this->dbpass; 
        
    }//getDBPass
    
    /*
    @param string dbport -> database port
    */
    private function setDBPort($dbport=3306){
        
        $this->dbport=intval($dbport);
        
    }//setDBPort
    
    public function getDBPort(){
        
        return $this->dbport;
        
    }//getDBPort
    
}//AmbaDatabaseConnector