<?php

/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions\Error;
use \Banquet\Core\SenderAction;

class Error extends SenderAction{
   	 

        public function send() {
            
        $this->setTemplateName("error/error"); 
       
       
        return $this->getTemplate("empty");
        
    }
    
    
}

?>
