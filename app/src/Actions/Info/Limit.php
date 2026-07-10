<?php

/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions\Info;
use Banquet\Ms\Core\Attribute\Route;
use Banquet\Ms\Core\SenderAction;

class Limit extends SenderAction{
   	 
     #[Route(FOLDER_HOME.'/limit', 'GET')]
        public function send() {
            
        $this->setTemplateName("info/security-click"); 
        $language=$this->loadLanguage();
        $this->varAdd('lang', $language); 
        return $this->getTemplate("empty");
        
    }
    
    
}

?>
