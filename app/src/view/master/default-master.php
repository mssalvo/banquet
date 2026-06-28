<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        
    <style>
     .loader {
    display: block;
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: #fafafa url('/app/brand/ico/page-loader.gif') no-repeat center center;
    text-align: center;
    color: #999;
    }
    </style>
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

 
            <?php if(isset($Carousel)){
               echo $Carousel;
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
        
       
        
<script type='text/javascript'>
 $(document).ready(function(){
 $(window).load(function() {
 $(".loader").fadeOut("slow");
 });
 })
 </script>   
 
 
    </body>
</html>
