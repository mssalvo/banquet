<?php

/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions\Notfound;
use Banquet\Ms\Core\Attribute\Route;
use Banquet\Ms\Core\SenderAction;

class Notauthorization extends SenderAction{
   	 
     #[Route(FOLDER_HOME.'/notauthorization', 'GET')]
        public function send() {
            
        $this->setTemplateName("notfound/notauthorization"); 
        $language=$this->loadLanguage();
        $this->varAdd('lang', $language); 
        return $this->getTemplate("notfound");
        
    }
    
    
}

?>
