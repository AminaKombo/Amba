<h1 class="red-text">Outbox</h1>

<p class="grey-text">View sent messages.</p><hr />

<?php $mail=$this->model->getSentMail();

if(count($mail)>0){ ?>

<ul class="collapsible" data-collapsible="accordion">
<?php

$cn=1;
    
foreach($mail as $message){
    
    $recips=explode(",",$message['recipient']);
    
    $count=count($recips);
    
    $recipCount=$count." recipients";
    
    if($count==1){
        
        $recipCount=substr($recipCount,0,-1);
    
    }//if
    
    ?>
    <li>
        
        <div class="collapsible-header <?php if($cn==1){echo "active";}?>"><!--header-->
            
            <div class="row"><!--row-->
                
                <div class="col s12 m2 l2"><!--column-->
                    
                    <i class="material-icons red-text">send</i> 
                    
                    <?php echo "<small>".$recipCount."</small>";?>
                    
                </div><!--column-->
                
                <div class="col s12 m7 l7"><!--column-->
                    
                    <?php echo $message['subject'];?>
                
                </div><!--column-->
                
                <div class="col s12 m3 l3 grey-text"><!--column-->
                    
                    <small>
                        
                        <i class="tiny material-icons left">event</i>
                        
                        <?php echo date("d/m/Y",strtotime($message['date']));?>
                    
                    </small>
                
                </div><!--column-->
                
            </div><!--row-->

        </div><!--header-->
        
        <div class="collapsible-body grey-text"><!--message body-->
            
            <div align="right"><?php echo date("h:ia l jS F, Y");?></div>

            <div class="collection"><!--recipients-->
                
                <?php foreach($recips as $recip){?>
                
                <div class="collection-item"><!--recipient-->
                    
                    <i class="material-icons left">person</i> <?php echo $recip;?>
                
                </div><!--recipient-->
                
                <?php }//foreach ?>
                
            </div><!--recipients-->

            <h3 class="red-text"><?php echo $message['subject'];?></h3>
            
            <?php echo $message['body'];?>
            
        </div><!--message body-->

    </li>
<?php $cn++;
    
}//foreach

?> 

</ul>

<?php }//if

else{
    ?>

<div class="grey-text md-24" align="center">

    <i class="large material-icons red-text">settings_power</i>
    
    <p>So...your outbox is empty.</p>
    
    <p>Oops.</p>
    
    <a href="<?php echo AMBALINK."demo/";?>" class="btn red btn-large">
        
        <i class="material-icons left">send</i> change that
    
    </a>
    
</div>


<?php }//else