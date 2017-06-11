<?php
/*
ambacontroller.php

Class AmbaController

base controller class for the application

*/
namespace Amba\Core;

class AmbaController{
   
    var $model;
    
    public function __construct($model){
       
        $this->model=$model;
        
        if(isset($_POST['amba'])){
            
            //if form data has been submitted, react to it
            $this->performAction($_POST['amba']);
            
        }//if
        
    }//constructor
    
    /*
    
    clear saved form data and notifications
    
    */
    protected function clearNotifications(){
        
        if(isset($_SESSION['amberr'])){
            
            unset($_SESSION['amberr']);
        
        }//if
        
        if(isset($_SESSION['ambrec'])){
            
            unset($_SESSION['ambrec']);
        
        }//if
        
        if(isset($_SESSION['success'])){
            
            unset($_SESSION['success']);
            
        }//if
        
    }//clearNotifications
    
    /*
    @param string requestPage -> application 'page' that submitted the form
    */
    public function performAction($requestPage){
        
        $this->clearNotifications();
        
        switch($requestPage){
            case "demo":
                
                $this->sendEmail();
                
            break;
            case "manage":
                
                $hasSender=$this->model->hasSender();
                
                if(!$hasSender){
                    
                    $this->manageSender("add");
                               
                }//if
                else{
                    
                    $this->manageSender("edit");
                    
                }//else
                
            break;
        }//switch
        
    }//performAction
    
    /*
    @param string[] array -> array of $_POSTed fields to check
    */
    protected function checkFormBlanks($array){
        
        foreach($array as $element){
            
            $label=$element;
            
            $element=str_replace(" ","",$_POST[$element]);
            
            $element=strip_tags($element);
            
            if(strlen($element)==0){
                
                $_SESSION['amberr'][$label]="required.";
            
            }//if
            
        }//foreach
        
    }//checkFormBlanks
    
    /*
    @param string[] array -> array of $_POSTed fields to save
    */
    protected function recoverFormData($array){
        
        foreach($array as $element){
            
            $label=$element;
            
            if(isset($_POST[$label])){
                
                $_SESSION['ambrec'][$label]=$_POST[$label];
            
            }//if
            
        }//foreach
        
    }//recoverFormData
    
    /*
    send an email to the defined recipient(s)
    */
    private function sendEmail(){
        
        $arr=array("drecipient","dsubject","dbody");
        
        $this->checkFormBlanks($arr);
        
        $this->recoverFormData($arr);
        
        if(strlen($_POST['drecipient'])<5){
            
            $_SESSION['amberr']['drecipient2']="huh?";
        
        }//if
        
        if(!isset($_SESSION['amberr'])){
            
            $this->clearNotifications();
            
            $subject=strip_tags($_POST['dsubject']);
            
            $sender=$this->model->getSender();
            
            $recipients=$this->getRecipients($_POST['drecipient']);
            
            $mailer=new \Amba\Core\AmbaMailer($sender->senderName,$sender->senderAddress,$sender->rawPassword);
                
            $sent=$mailer->sendMail($recipients,$subject,$_POST['dbody']);
            
            if($sent && ALLOWOUTBOX){
                
                $this->model->saveOutGoingMail($recipients,$subject,$_POST['dbody']);
                
            }//if
            
        }//if
        
        if(isset($sent) && $sent==true){
            
            if(ALLOWOUTBOX!==true){
                
                header("Location: ".AMBALINK."demo/");
            
            }//if
            else{
                
                header("Location: ".AMBALINK."outbox/#hustle");
            
            }//else
        
        }//if
        
    }//sendEmail
    
    /*
    @param string recipientString
    @return string[] recipients -> array of email addresses
    */
    protected function getRecipients($recipientString){//comma-separated
        
        $recipientString=str_replace(" ","",$recipientString);
        
        $unformattedRecipients=explode(",",$recipientString);
        
        $recipients=array();
        
        foreach($unformattedRecipients as $recip){
            
            if(filter_var($recip, FILTER_VALIDATE_EMAIL)){
                
                if(!in_array($recip,$recipients)){
                    
                    $recipients[]=$recip;
                
                }//if
                
            }//if
            else{
                
                $_SESSION['amberr']['drecipient2']="must be emails.";
                
            }//else
            
        }//foreach
        
        return $recipients;
        
    }//getRecipients
    
    /*
    @param string action -> action to perform on the amb_sender table
    */
    private function manageSender($action="edit"){
        
        //currently configured for ONE email sender
        
        $arr=array("sname","semail","confsemail","spass","confspass");
        
        $this->checkFormBlanks($arr);
        
        $this->recoverFormData(array("sname","semail","confsemail"));
        
        if($_POST['semail']!==$_POST['confsemail']){
            
            $_SESSION['amberr']['confsemail2']="emails must match.";
            
        }//if
        if($_POST['spass']!==$_POST['confspass']){
            
            $_SESSION['amberr']['confspass2']="passwords must match.";
            
        }//if
        
        if(!isset($_SESSION['amberr'])){
            
            if(isset($_SESSION['ambrec'])){
                
                unset($_SESSION['ambrec']);
            
            }//if
            
            switch($action){
                case "add":
                    
                    $senderSaved=$this->model->createSender();
                    
                break;
                case "edit":
                    
                    $senderSaved=$this->model->editSender();
                    
                break;
            }//switch
            
            if($senderSaved){
                
                //send confirmation email
                
                $sender=$this->model->getSender();
                
                $mailer=new \Amba\Core\AmbaMailer($sender->senderName,
                                                  $sender->senderAddress,
                                                  $sender->rawPassword);
                
                $to=$sender->senderAddress;
                
                $subject="Testing Email";
                
                $text="<p>If you're reading this, it worked.</p>";
                
                $sent=$mailer->sendMail($to,$subject,$text);
                
            }//if
            
        }//if
        
        if(isset($sent) && $sent==true){
            
            header("Location: ".AMBALINK."manage/#hustle");
        
        }//if
        
    }//manageSender

}//AmbaController