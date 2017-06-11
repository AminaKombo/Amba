<?php

if(!isset($_SESSION)){
    
    session_start();

}//if

if(!defined('DS')){
    
    define('DS',DIRECTORY_SEPARATOR);

}//if

require_once(__DIR__.DS."vendor".DS."autoload.php");

$amba=new \Amba\Core\Amba("app".DS."config".DS."config.php");