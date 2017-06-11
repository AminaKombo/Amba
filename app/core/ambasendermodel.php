<?php
/*
ambasendermodel.php

Class AmbaSenderModel

data model of amb_sender table
*/
namespace Amba\Core;

class AmbaSenderModel extends \Amba\Core\SenderPasswordHasher{
    
    var $senderName;
    
    var $senderAddress;
    
    var $senderPassword;
    
    var $rawPassword;
    
    var $salt;
    
    public function __construct($name,$email,$password,$salt){
        
        $this->senderName=$name;
        
        $this->senderAddress=$email;
        
        $this->senderPassword=$password;
        
        $this->salt=$salt;
        
        $this->rawPassword=parent::unhashSenderPassword($this->senderPassword,$this->salt);
        
    }//constructor
    
}//AmbaSenderModel