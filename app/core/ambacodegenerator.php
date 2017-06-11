<?php
/*
ambacodegenerator.php

Class AmbaCodeGenerator

generates a random code string

*/
namespace Amba\Core;

class AmbaCodeGenerator{
    
    /*
    @param int length-> length of code string
    @return string code-> generated code
    */
    public function generateRandomCode($length=12){
        
        $code="";
       
        $base="abcdefghjkmnpqrstuvxyz";//confusable characters removed
        
        $base.=strtoupper($base);
        
        $base.="23456789";
        
        $baseLength=strlen($base);
        
        for($index=0; $index<$length; $index++){
            
            $code.=$base[mt_rand(0,$baseLength-1)];
            
        }//for
        
        return $code;
        
    }//generateRandomCode
    
}//AmbaCodeGenerator