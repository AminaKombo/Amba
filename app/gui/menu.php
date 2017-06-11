<nav class="red darken-1">
    
    <div class="nav-wrapper"><!--wrapper-->
        
      <ul id="nav-mobile" class="right">
          
          <?php
          
          foreach($this->model->menuEntries as $entry){
              echo "<li class='";
              
              if(isset($_GET['wapi']) && $_GET['wapi']==$entry['url']){
                  
                  echo "active";
              
              }//if
              
              echo "'>
              
              <a href='".AMBALINK.$entry['url']."/#hustle'>
              
                <i class='material-icons left'>".$entry['icon']."</i>".$entry['title']."
                
                </a>
                
                </li>";
          }//foreach
          
          ?>
          
          <li>
              
              <a href="<?php echo DOWNLOADLINK;?>" target="_blank">
                  
                  <i class="material-icons left">file_download</i>Download
              
              </a>
          
          </li>
          
      </ul>
        
    </div><!--wrapper-->
    
  </nav>