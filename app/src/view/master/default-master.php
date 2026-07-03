<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
 
    <?php if(isset($Header)){
               echo $Header;
                }
             ?>
    </head>
     <body>
           
                    <?php if(isset($Menu)){
                           echo $Menu;
                         }
                    ?>     
              
 <div class="container marketing">                
            <?php if(isset($default)){
                       echo $default;
                        }
                     ?> 
     
            <?php if(isset($Footer)){
                       echo $Footer;
                        }
                     ?> 
        </div><!-- /.container -->    
        
       
        
  
 
 
    </body>
</html>
