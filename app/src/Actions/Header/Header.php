<?php

/**
 * Description of header
 *
 * @author Utente
 */
namespace Banquet\Actions\Header;
use \Banquet\Core\SenderAction;

class Header extends SenderAction{
    public function send() {
        $this->setTemplateName("header/header");
        $this->varAdd('title', '');
       
        $language=$this->load("message_".$this->getLangName().".php");
        $this->varAdd('lang', $language);
       
        return $this->getTemplate();
    }     
}

?>
