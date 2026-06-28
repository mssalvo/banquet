<?php

/**
 * Description of start
 *
 * @author Utente
 */
namespace Banquet\Actions;
use \Banquet\Core\SenderAction;

class Logout extends SenderAction{

        public function send() {
            
        $this->setTemplateName("pages/login");
     
        // $_SESSION[TEXT_USER]=NULL;
        // session_unset();
        $this->deleteAllKeySession();
      
        $this->redirect('/home', 'refresh'); 
        
    }
    
    
}

?>
