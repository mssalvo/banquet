<?php

/**
 * Description of footer
 *
 * @author Utente
 */

namespace Banquet\Actions\Menu;
use Banquet\Ms\Core\SenderAction;

class Menu extends SenderAction{

    public function send() {
        $this->setTemplateName("menu/menu");
        
        $language=$this->load("message_".$this->getLangName().".php");
        $this->varAdd('lang', $language); 
        
        return $this->getTemplate();
        
    }     
}

?>
