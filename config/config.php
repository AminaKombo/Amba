<?php
/*
config.php

Set important constants

@const AMBALINK-> link to application
*/
if(!defined('AMBALINK')){
    
    define('AMBALINK','http://your-link-here/');

}//if

/*
@const AMBAVERSION-> version of installation. Change it to your own value, if you like
*/
if(!defined('AMBAVERSION')){
    
    define('AMBAVERSION','1.1.beta');

}//if

/*
@const APPTITLE-> title of application
*/
if(!defined('APPTITLE')){
    
    define('APPTITLE','Amba');

}//if

/*
@const COPYRIGHTINFO-> copyright information, appears in app/gui/footer.php
*/
if(!defined('COPYRIGHTINFO')){
    
    define('COPYRIGHTINFO','&copy;'.date('Y').' Amina Kombo');

}//if


/*

Amba Settings

@const ALLOWATTACHMENTS-> turn attachments on/off
*/
if(!defined('ALLOWATTACHMENTS')){
    
    define('ALLOWATTACHMENTS',true);

}//if

/*
@const ALLOWOUTBOX-> turn outbox on/off
setting it to false will NOT save outgoing messages to database
*/
if(!defined('ALLOWOUTBOX')){
    
    define('ALLOWOUTBOX',true);

}//if

/*
@const DOWNLOADLINK-> link to the Amba repo. change it to your own.
*/
if(!defined('DOWNLOADLINK')){
    
    define('DOWNLOADLINK','https://github.com/AminaKombo/Amba');

}//if

/*

Database Settings

@const DBHOST-> name of host
*/
if(!defined('DBHOST')){
    
    define('DBHOST','localhost');

}//if

/*
@const DBNAME-> name of database
*/
if(!defined('DBNAME')){
    
    define('DBNAME','amba1');

}//if

/*
@const DBUSER-> name of database user account
*/
if(!defined('DBUSER')){
    
    define('DBUSER','root');

}//if

/*
@const DBPASS-> database password
*/
if(!defined('DBPASS')){
    
    define('DBPASS','root');

}//if

/*
@const DBPORT-> database port
*/
if(!defined('DBPORT')){
    
    define('DBPORT',3306);

}//if