<?php

/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions\Error;
use Banquet\Ms\Core\SenderAction;

class ErrorRest extends SenderAction{
   	 

        public function send() {
            
        $this->setTemplateName("error/error-rest"); 
       
        $this->getResponse()->addHeader('Content-Type: application/json');
        
        return $this->getTemplate("empty");
        
    }
    
    
}

?>