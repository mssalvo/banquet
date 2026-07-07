<?php

/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions\Notfound;
use Banquet\Ms\Core\Attribute\Route;
use Banquet\Ms\Core\SenderAction;

class Notfound extends SenderAction{
   	 
        #[Route(FOLDER_HOME.'/notfound', 'GET')]
        public function send() {
            
        $this->setTemplateName("notfound/notfound"); 
        $language=$this->loadLanguage();
        $this->varAdd('lang', $language); 
        return $this->getTemplate("notfound");
        
    }
    
    
}

?>
