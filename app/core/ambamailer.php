<?php
/*
ambamailer.php

class AmbaMailer

sends formatted emails, using PHPMailer

*/
namespace Amba\Core;

class AmbaMailer{
    
    var $EMAIL="";
    
    var $PASSWORD="";
    
    var $PORT=587;
    
    var $HOST="smtp.gmail.com";
    
    var $MAIL;
    
    var $CONTACTS=array();
    
    var $MAILERNAME="";
    
    /*
    @param string name -> name which appears in the "From" email field
    @param string email -> email address of the sender
    @param string password -> password of the sender, saved as a hashed 
    value in the database
    */
    public function __construct($name,$email,$password){
        //set class attributes
        //name which appears in the "From" email field
        $this->MAILERNAME=$name;
        
        //sender's email address
        $this->EMAIL=$email;
        
        //sender's password
        $this->PASSWORD=$password;
        
        //contacts for the email's footer
        $this->CONTACTS=$this->getFooterContacts();
        
        //define a new PHPMailer object
        $this->MAIL=new \PHPMailer();
        
        //leave these lines commented out if you're developing on
        //a local machine.
        
        /*$this->MAIL->SMTPDebug=4;
        
        $this->MAIL->Debugoutput = 'html';
        
        //$this->MAIL->Host = gethostbyname($this->HOST);//if your host is an IP Address
        $this->MAIL->isSMTP();
        
        $this->MAIL->SMTPAuth=true;
        
        $this->MAIL->SMTPSecure='tls';*/
        
        $this->MAIL->Host=$this->HOST;//comment this out if you've set $this->HOST above
        
        //define mailer port
        $this->MAIL->Port=$this->PORT;
        
        //define sender username (email address)
        $this->MAIL->Username=$this->EMAIL;
        
        //define sender password (stored as a hashed value in the database)
        $this->MAIL->Password=$this->PASSWORD;
        
        //allow HTML emails
        $this->MAIL->isHTML(true);
        
    }//constructor
    
    /*
    @param string to -> recipient's email address
    @param string subject -> subject of the email
    @param string text -> body of the email
    @return boolean verdict -> outcome of sending an email
    */
    public function sendMail($to,$subject,$text){
        //send an email
        $verdict=false;
        
        //set the "From" fields
        $this->MAIL->setFrom($this->EMAIL,$this->MAILERNAME);
        
        //set email subject
        $this->MAIL->Subject=$subject;
        
        //set html body
        $this->MAIL->Body=$this->formatBody($subject,$text);
        
        //set non-html body
        $plaintext=str_replace("<p>","",$text);
        
        $plaintext=str_replace("</p>","\n",$plaintext);
        
        $plaintext=strip_tags($plaintext);
        
        $this->MAIL->AltBody=$plaintext;
        
        if(!is_array($to)){
            
            //set recipient's address
            $this->MAIL->AddAddress($to);

            if($this->MAIL->send()){

                $_SESSION['success']="Email successfully sent to ".$to;

                $verdict=true;

            }//if
            else{

                $_SESSION['amberr']['mail']="mailer error: ".$this->MAIL->ErrorInfo;

                $verdict=false;

            }//else
        
        }//if
        else{
            
            $successString="Email successfully sent to ";
            
            foreach($to as $recipient){
                //set recipient's address
                $this->MAIL->AddAddress($recipient);

                if($this->MAIL->send()){

                    $successString.=$recipient.", ";

                    $verdict=true;

                }//if
                else{

                    $_SESSION['amberr']['mail']="mailer error: ".$this->MAIL->ErrorInfo;

                    $verdict=false;
                    
                    break;
                }//else
                
                $this->MAIL->ClearAddresses();
                //$this->MAIL->clearAttachments();
                
            }//foreach
            
            $successString=substr($successString,0,-2);
            
            $_SESSION['success']=$successString;
            
        }//else
            
        return $verdict;
        
    }//sendMail
    
    /*
    @param string subject -> subject of the email
    @param string text -> email message, to be formatted into an email body
    @return body -> formatted email body string
    */
    private function formatBody($subject,$text){
        //format body of html email
        
        $body="<html lang='en'><head>
        
        <style type='text/css'>
            body{
                font-size: 18px !important; 
                font-weight: normal !important;
                line-height: 15px; 
                background-color: #eaeaea !important; 
                padding: 25px !important;
            }
            h1, h2, h3 h4, h5, h6{
                color: #e53935 !important;
            }
            .banner{
                background-color: #e53935; 
                color:white !important; 
                font-size: 36px; 
                text-align: center; 
                width: 100%; 
                padding: 25px; 
                border-bottom: 2px solid #881f1c;
            }
            .content{
                padding: 25px; 
                font-size: 18px; 
                background-color: #eaeaea !important;
            }
            .footer{
                font-size: 12px; 
                padding: 25px; 
                border-top: 2px solid #881f1c;
            }
            .contact{
                padding: 5px; 
                margin-right: 25px;
            }
            table td{
                color: #000;
            }
        </style>
        
        </head>
        
        <body>
        
            <div class='banner'>
                
                ".$subject."
                
            </div>
                
            <div class='content'>";
        
                $body.=$text;
        
            $body.="</div>";

            //add footer contacts
            if(count($this->CONTACTS)>0){

                $body.="<div class='footer'>";

                foreach($this->CONTACTS as $cont){

                    $body.="<span class='contact'>".$cont."</span>";

                }//foreach

                $body.="</div>";

            }//if

        //close <body> and <html> tags
        
        $body.="</body>
        
        </html>";
        
        return $body;
        
    }//formatBody
    
    /*
    @return mixed[] contactArray -> string of contacts for the email footer
    */
    private function getFooterContacts(){
        //returns contacts for the email's footer.
        
        $arr=array("This message was sent by <strong><a href='".AMBALINK."'>".APPTITLE."</a></strong>");
        
        return $arr;
        
    }//getFooterContacts
    
}//AmbaMailer