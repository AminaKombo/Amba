<?php

$sender=$this->model->getSender();

if($sender==null){
    
    $sname="Amba Mailer"; 
    
    $semail="info@example.com";

}//if
else{
    
    $sname=$sender->senderName; 
    
    $semail=$sender->senderAddress;
    
}//else
?>

<form method="post">

    <div class="row"><!--row-->
        
        <div class="col s12 m12 l12"><!--column-->
            
            <label for="sname">Sender Name</label>
            
            <input type="text" name="sname" id="sname" placeholder="name of sender" 
                   value="<?php $this->showRecovered("sname",$sname);?>" />
            
            <?php $this->showError("sname");?> <?php $this->showError("sname2");?>
            
        </div>
        
        <div class="col s12 m6 l6"><!--column-->
            
            <label for="semail">Sender Address</label>
            
            <input type="email" name="semail" id="semail" placeholder="sender address" 
                   value="<?php $this->showRecovered("semail",$semail);?>" />
            
            <?php $this->showError("semail");?> <?php $this->showError("semail2");?>
            
        </div><!--column-->
        
        <div class="col s12 m6 l6"><!--column-->
            
            <label for="confsemail">Confirm Sender Address</label>
            
            <input type="email" name="confsemail" id="confsemail" placeholder="confirm the address" 
                   value="<?php $this->showRecovered("confsemail",$semail);?>" />
            
            <?php $this->showError("confsemail");?> <?php $this->showError("confsemail2");?>
            
        </div><!--column-->
        
        <div class="col s12 m6 l6"><!--column-->
            
            <label for="spass">Sender Password</label>
            
            <input type="password" name="spass" id="spass" placeholder="your sender password" />
            
            <?php $this->showError("spass");?> <?php $this->showError("spass2");?>
            
        </div><!--column-->
        
        <div class="col s12 m6 l6"><!--column-->
            
            <label for="confspass">Confirm Sender Password</label>
            
            <input type="password" name="confspass" id="confspass" placeholder="confirm your sender password" />
            
            <?php $this->showError("confspass");?> <?php $this->showError("confspass2");?>
            
        </div><!--column-->
        
        <div class="col s12 m12 l12" align="center"><!--column-->
            
            <hr />
            
            <button type="submit" class="btn btn-large red white-text" name="amba" 
                    value="<?php echo $_GET['wapi'];?>">
                
                <i class="material-icons right">send</i> Send Email
            
            </button>
            
        </div><!--column-->
        
    </div><!--row-->
    
</form>