<h1 class="red-text">Manage</h1>

<p class="grey-text">Use the form on this page to manage your email sender.</p><hr />

<div class="row"><!--row-->
    
    <?php if($this->model->hasSender()){?>
    
    <div class="col s12 m6 l6"><!--column-->

        <?php

        $sender=$this->model->getSender();

        ?>
          <div class="card"><!--card-->
              
            <div class="card-content grey-text"><!--content-->
                
              <span class="card-title red-text">
                  
                  <i class="material-icons left">lightbulb_outline</i> Current Sender
                
                </span>
                
                <?php
                echo "<h2 class='red-text'>".$sender->senderName."</h2>";
    
                echo "<big>".$sender->senderAddress."</big><hr />";
                ?>
                
                <p>All outgoing emails will be in ^that address' 'sent items/outbox' folder.</p>
                
                <p>Why's it called a 'sender address' and not 'sender email'?</p>
                
                <p>Because there are plans to extend capabilities to include other means of communication.</p>
                
                <hr />
                
                <i class="large red-text material-icons" title="emails">mail</i> 
                
                <i class="large material-icons" title="text messages">perm_phone_msg</i>
                
                <i class="large material-icons" title="chat">chat</i> 
                
                <i class="large material-icons" title="social sharing">share</i>
                
            </div><!--content-->
              
          </div><!--card-->

    </div><!--column-->
    
    <?php }?>
    
    <div class="col s12 m6 l6"><!--column-->
        
        <?php
        
        $title="New Sender";

        if($this->model->hasSender()){
            
            $title="Edit Current Sender";
        
        }//if
        
        ?>
        <h4 class="red-text"><?php echo $title;?></h4>
        
        <p class="grey-text">Create a new email sender.</p>
        
        <?php
        
        if(isset($_SESSION['success'])){
        
        ?>
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
        <?php
         
         }//if
        
        ?>
        
        <hr />
        
        <?php include "app".DS."display".DS."manage".DS."setup_sender.php";?>
        
    </div><!--column-->
    
</div><!--row-->
           