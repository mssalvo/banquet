<?php

/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions\Notfound;
use \Banquet\Core\SenderAction;

class Notfound extends SenderAction{
   	 

        public function send() {
            
        $this->setTemplateName("notfound/notfound"); 
        $language=$this->load("message_".$this->getLangName().".php");
        $this->varAdd('lang', $language); 
        return $this->getTemplate("notfound");
        
    }
    
    
}

?>
