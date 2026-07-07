<?php

/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions;

use Banquet\Ms\Core\Attribute\Route;
use Banquet\Ms\Core\SenderAction;

class Logout extends SenderAction{
        
        #[Route(FOLDER_HOME.'/logout', 'GET')]
        public function send() {
            
        $this->setTemplateName("pages/login");
     
        // $_SESSION[TEXT_USER]=NULL;
        // session_unset();
        $this->deleteAllKeySession();
      
        $this->redirect('/home', 'refresh'); 
        
    }
    
    
}

?>
