<?php
/*
senderpasswordhasher.php

Class SenderPasswordHasher

hashed (and unhashes) the sender's password

if you edit the methods, do NOT use one-way encryption

*/
namespace Amba\Core;

class SenderPasswordHasher{
    
    /*
    @param string rawPassword-> unhashed password string
    @param string salt-> salt of the sender's record
    @return string result-> hashed password string
    */
    public function hashSenderPassword($rawPassword,$salt){
        
        $result="";
        
        $result=base64_encode(strrev($rawPassword).$salt);
        
        return $result;
        
    }//hashSenderPassword
    
    /*
    @param string hashedPasswowrd-> hashed password string
    @param string salt -> salt of the sender's record
    @return string result-> unhashed password string
    */
    public function unhashSenderPassword($hashedPassword,$salt){
        
        $result="";
        
        $result=base64_decode($hashedPassword);
        
        $result=substr($result,0,-1*strlen($salt));
        
        $result=strrev($result);
        
        return $result;
        
    }//unhashSenderPassword
    
}//SenderPasswordHasher