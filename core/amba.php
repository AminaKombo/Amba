<?php
/*
amba.php

Class Amba

Amba application front controller

*/
namespace Amba\Core;

class Amba{
    
    var $validPlaces=array();
    
    var $logicModel;
    
    /*
    @param string configFile-> path to configuration file
    */
    public function __construct($configFile){
       
        //set constants
        require_once($configFile);
        
        //validPlaces-> 'pages' of the application
        $this->validPlaces=$this->getValidPlaces();
        
        //determine current page
        $wapi="";
        
        if(isset($_GET['wapi'])){
            
            $wapi=$_GET['wapi'];
        
        }//if
        
        if(!in_array($wapi,$this->validPlaces)){
            
            //if the current page is NOT a valid entry, send it to the first default page
            header("Location: ".AMBALINK.$this->validPlaces[0]."/");
            
        }//if
        else{
            //current page IS a valid entry
            //create an AmbaLogicModel object to connect to the database
            $this->logicModel=new \Amba\Core\AmbaLogicModel();
            
            //activate the application ('show the pages')
            $this->activate();
            
        }//else
        
    }//constructor
    
    /*
    @return string[] getValidPlaces-> array of files
    */
    private function getValidPlaces(){
        
        //determine valid 'pages' based on settings in app/config/config.php
        
        $arr=array("demo");
        
        if(ALLOWOUTBOX==true || ALLOWOUTBOX==1){
            
            $arr[]="outbox";
        
        }//if
        
        $arr[]="manage";
        
        return $arr;
        
    }//getValidPlaces
    
    /*
    declare a view object and activate it
    */
    private function activate(){
        
        //show the current application 'page'
        
        switch($_GET['wapi']){
            case "demo":
                
                $fileArray=array("app".DS."display".DS."demo".DS."demo.php");
                
            break;
            case "outbox":
                
                $fileArray=array("app".DS."display".DS."outbox".DS."outbox.php");
                
            break;
            case "manage":
                
                $fileArray=array("app".DS."display".DS."manage".DS."manage.php");
                
            break;
        }//switch
        
        //if fileArray is set, create an AmbaView object
        if(isset($fileArray)){
            
            $model=new \Amba\Core\AmbaModel();
            
            $controller=new \Amba\Core\AmbaController($model);
            
            $view=new \Amba\Core\AmbaView($controller,$fileArray);
            
            $view->load();
            
        }//if
        
    }//activate
    
}//Amba