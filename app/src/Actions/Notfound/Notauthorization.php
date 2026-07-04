<?php

/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions\Notfound;
use \Banquet\Core\SenderAction;

class Notauthorization extends SenderAction{
   	 

        public function send() {
            
        $this->setTemplateName("notfound/notauthorization"); 
        $language=$this->load("message_".$this->getLangName().".php");
        $this->varAdd('lang', $language); 
        return $this->getTemplate("notfound");
        
    }
    
    
}

?>
