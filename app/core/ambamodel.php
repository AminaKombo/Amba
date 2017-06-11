<?php
/*
ambamodel.php

class AmbaModel

base model class for the application
*/
namespace Amba\Core;

class AmbaModel extends \Amba\Core\AmbaLogicModel{
    
    var $menuEntries=array();
    
    public function __construct(){
       
        parent::__construct();
        
        $this->menuEntries=$this->getMenuEntries();
        
    }//constructor
    
    /*
    @return mixed[] entries -> array of menu entries
    */
    protected function getMenuEntries(){
        
        $entries[]=array("title"=>"Demo","url"=>"demo","icon"=>"mail");
        
        if(ALLOWOUTBOX){
            
            $entries[]=array("title"=>"Outbox","url"=>"outbox","icon"=>"send");
            
        }//if
        
        $entries[]=array("title"=>"Manage","url"=>"manage","icon"=>"subject");
        
        return $entries;
        
    }//getMenuEntries
    
    /*
    @return boolean verdict -> true or false result of query
    */
    public function hasSender(){
        
        $verdict=false;
        
        $st=$this->dbcon->executeQuery("SELECT COUNT(*) FROM amb_sender",
                                       array());
        if($st->fetchColumn()>0){
            
            $verdict=true;
        
        }//if
        
        return $verdict;
        
    }//hasSender
    
    /*
    @return AmbaSenderModel sender -> sender object resultant from query
    */
    public function getSender(){
        
        $sender=null;
        
        if($this->hasSender()){
            
            $st=$this->dbcon->executeQuery("SELECT * FROM amb_sender ORDER BY senderID DESC LIMIT 1",
                                           array());
            
            while($ro=$st->fetchObject()){
                
                $sender=new \Amba\Core\AmbaSenderModel($ro->senderName,
                                                       $ro->senderAddress,
                                                       $ro->senderPassword,
                                                       $ro->salt);
                
            }//while
            
        }//if
        
        return $sender;
        
    }//getSender
    
    /*
    @return mixed[] mail-> array of sent emails
    */
    public function getSentMail(){
        
        $mail=array();
        
        $query="SELECT * FROM amb_outgoing ORDER BY sendDate DESC";
        
        $vals=array();
        
        $st=$this->dbcon->executeQuery($query,$vals);
        
        while($ro=$st->fetchObject()){
            
            $mail[]=array("messageid"=>$ro->messageID,
                          "recipient"=>$ro->recipient,
                          "subject"=>$ro->subject,
                          "body"=>$ro->body,
                          "date"=>$ro->sendDate);
            
        }//while
        
        return $mail;
        
    }//getSentEmail
    
    /*
    @return boolean verdict-> outcome of action
    */
    public function createSender(){
       
        $verdict=false;
        
        $hasher=new \Amba\Core\SenderPasswordHasher();
        
        $codegen=new \Amba\Core\AmbaCodeGenerator();
        
        $salt=$codegen->generateRandomCode();
        
        $hashedPassword=$hasher->hashSenderPassword($_POST['spass'],$salt);
        
        $query="INSERT INTO amb_sender(senderName,senderAddress,senderPassword,salt) VALUES(?,?,?,?)";
        
        $vals=array($_POST['sname'],$_POST['semail'],$hashedPassword,$salt);
        
        $st=$this->dbcon->executeQuery($query,$vals);
        
        $st=$this->dbcon->executeQuery("SELECT COUNT(*) FROM amb_sender WHERE senderAddress=?",
                                      array($_POST['semail']));
        if($st->fetchColumn()>0){
            
            $verdict=true;
        
        }//if
        
        if(!$verdict){
            
            $_SESSION['amberr']['sname']="sender could not be saved.";
            
            $_SESSION['ambrec']['semail']=$_POST['semail'];
            
            $_SESSION['ambrec']['confsemail']=$_POST['semail'];
            
            $_SESSION['ambrec']['sname']=$_POST['sname'];
            
        }//if
        
        return $verdict;
        
    }//createSender
    
    /*
    @param boolean return verdict-> true or false depending on outcome
    */
    public function editSender(){
        
        $verdict=false;
       
        $sender=$this->getSender();
        
        $hasher=new \Amba\Core\SenderPasswordHasher();
        
        $codegen=new \Amba\Core\AmbaCodeGenerator();
        
        $salt=$codegen->generateRandomCode();
        
        $hashedPassword=$hasher->hashSenderPassword($_POST['spass'],$salt);
        
        $query="UPDATE amb_sender SET senderName=?,senderAddress=?,senderPassword=?,salt=? WHERE senderAddress=?";
        
        $vals=array($_POST['sname'],$_POST['semail'],$hashedPassword,$salt,$sender->senderAddress);
        
        $st=$this->dbcon->executeQuery($query,$vals);
        
        $checkQuery="SELECT COUNT(*) FROM amb_sender WHERE senderName=? AND senderAddress=? AND senderPassword=? AND salt=?";
        
        unset($vals[4]);
        
        $st=$this->dbcon->executeQuery($checkQuery,$vals);
        
        if($st->fetchColumn()==1){
            
            $verdict=true;
        
        }//if
        
        if(!$verdict){
            
            $_SESSION['amberr']['sname']="changes could not be saved.";
            
            $_SESSION['ambrec']['semail']=$_POST['semail'];
            
            $_SESSION['ambrec']['confsemail']=$_POST['semail'];
            
            $_SESSION['ambrec']['sname']=$_POST['sname'];
            
        }//if
        
        return $verdict;
        
    }//editSender
    
    /*
    @param mixed[] recipients-> array of recipient addresses
    @param string subject-> subject of outgoing email
    @param string body-> body of outgoing email
    @param mixed[] attachments-> URLS of attachments
    */
    public function saveOutGoingMail($recipients,$subject,$body,$attachments=null){
        
        $recipients=implode(",",$recipients);
        
        $query="INSERT INTO amb_outgoing(recipient,subject,body) VALUES(?,?,?)";
        
        $vals=array($recipients,$subject,$body);
        
        $st=$this->dbcon->executeQuery($query,$vals);
        
    }//saveOutGoingMail
    
}//AmbaModel