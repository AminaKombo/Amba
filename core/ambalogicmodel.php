<?php
/*
ambalogicmodel.php

class AmbaLogicModel

interacts with the database, through a database connector
is a parent class
*/
namespace Amba\Core;

class AmbaLogicModel {
   
    protected $dbcon;
    
    public function __construct(){
        
        $connect=$this->defineDatabaseConnectionObject();
        
    }//constructor
    
    /*
    @return boolean hasConnectionError-> outcome of action
    */
    public function defineDatabaseConnectionObject(){
       
        $constantsArray=array('DBHOST','DBNAME','DBUSER','DBPASS','DBPORT');
        
        $notSet=0;
        
        foreach($constantsArray as $item){
            
            if(!defined(($item))){
                
                $notSet++;
                
            }//if
            
        }//foreach
        
        if($notSet==0){
            
            $setupArray=array("dbhost"=>DBHOST,
                              "dbname"=>DBNAME,
                              "dbuser"=>DBUSER,
                              "dbpass"=>DBPASS,
                              "dbport"=>DBPORT);
            
            $this->dbcon=new \Amba\Core\AmbaDatabaseConnector($setupArray);
            
        }//if
        
        $this->dbcon->openConnection();
        
        return $this->dbcon->hasConnectionError;
        
    }//defineDatavaseConnectionObject
    
}//logicModel