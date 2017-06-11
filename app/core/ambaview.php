<?php
/*
ambaview.php

Class AmbaView

base view class for application
*/
namespace Amba\Core;

class AmbaView{
   
    var $controller;
    
    var $files=array("");
    
    var $model;
    
    /*
    @param AmbaController controller-> controller for this class
    @param mixed[] fileArray-> array of files to be included
    */
    public function __construct($controller,$fileArray=null){
       
        $this->controller=$controller;
        
        $this->model=$controller->model;
        
        if(isset($fileArray)){
            
            $this->files=$fileArray;
        
        }//if
        
    }//constructor
    
    /*
    includes files needed for current application 'page'
    */
    public function load(){
        
        include "app".DS."gui".DS."top.php";
        
        foreach($this->files as $file){
            
            include $file;
            
        }//foreach
        
        include "app".DS."gui".DS."bottom.php";
        
    }//load
    
    /*
    @param string index-> element label of error session variable
    */
    public function showError($index){
        
        if(isset($_SESSION['amberr'][$index])){
            
            include "app".DS."gui".DS."form_error.php";
            
        }//if
        
    }//showError
    
    /*
    @param string index-> element to be saved
    @param string default-> item to be displayed if the field is not found
    */
    public function showRecovered($index,$default=null){
        
        if(isset($_SESSION['ambrec'][$index])){
            
            echo $_SESSION['ambrec'][$index];
            
        }//if
        else{
            
            echo $default;
            
        }//else
        
    }//show
    
}//AmbaView