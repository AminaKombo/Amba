<h1 class="red-text">Demo</h1>

<p class="grey-text">Use the form on this page to test this project.</p>

<?php

if(isset($_SESSION['success'])){?>
    <hr />
    <div class="green-text">
        
        <i class="material-icons left">done</i> <?php echo $_SESSION['success'];?>
        
    </div>
<?php }//if

if(isset($_SESSION['amberr']['mail'])){
    ?>
    <hr />
    <div class="red-text">
        
        <i class="material-icons left">warning</i> <?php echo $_SESSION['amberr']['mail'];?>
        
    </div>

<?php }//if ?>

<hr />

<?php 
if($this->model->hasSender()){
    
    include "app".DS."display".DS."demo".DS."send_mail.php";

}//if
else{ ?>
    <div class="content" align="center"><!--wrapper-->
        
        <h1 class="red-text">
            
            <i class="large material-icons">mail</i>
        
        </h1><hr />
        
        <div class="grey-text">
            
            <p>This system needs an email sender to function.</p>
            
            <div align="left">
                
                <dl>
                    <dt>Email Sender</dt>
                    <dd>Also known as a "sender": is a REAL email address through which messages are sent.</dd>
                    <dd>Sender passwords are saved in the database as hashed values.</dd>
                    <dd>Because it's a <strong>BAD IDEA</strong> to save raw passwords.</dd>
                </dl>
                
            </div>
            
            <p>And you don't have one.</p>
            
            <a href="<?php echo AMBALINK."manage/";?>" class="btn btn-large red">
                
                <i class="material-icons left">subject</i> set one up
            
            </a>
            
        </div>
        
        <br />
        
    </div><!--wrapper-->

<?php }
        