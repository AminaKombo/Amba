<form method="post" enctype="multipart/form-data">
    
    <div class="row"><!--row-->
        
        <div class="col s12 m12 l12"><!--column-->
            
            <label for="drecipient">Recipient(s): (comma-separated email addresses)</label>
            
            <input type="text" name="drecipient" id="drecipient" 
                   value="<?php $this->showRecovered("drecipient");?>" 
                   placeholder="recipient emails"/>
            
            <?php $this->showError("drecipient");?> <?php $this->showError("drecipient2");?>
            
        </div><!--column-->
        
        <div class="col s12 m12 l12"><!--column-->
            
            <label for="dsubject">Subject:</label>
            
            <input type="text" name="dsubject" id="dsubject" 
                   value="<?php $this->showRecovered("dsubject");?>" 
                   placeholder="subject"/>
            
            <?php $this->showError("dsubject");?>
            
        </div><!--column-->
        
        <div class="col s12 m12 l12"><!--column-->
        
            <textarea name="dbody" id="dbody" class="trumbo" placeholder="email body">
                
                <?php $this->showRecovered("dbody");?>
            
            </textarea>
            
            <?php $this->showError("dbody");?> <?php $this->showError("dbody2");?>
            
        </div><!--column-->
        
        <div class="col s12 m12 l12" align="center"><!--column-->
            
            <hr />
            
            <button type="submit" class="btn btn-large red white-text" 
                    name="amba" 
                    value="<?php echo $_GET['wapi'];?>">
                
                <i class="material-icons right">send</i> Send Email
            
            </button>
            
        </div><!--column-->
        
    </div><!--row-->
    
</form>